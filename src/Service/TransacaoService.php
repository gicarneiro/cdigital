<?php

namespace App\Service;

use App\Entity\Transacao;
use App\Message\TransacaoMessage;
use App\Service\CarteiraDigitalService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class TransacaoService {

    /**
    * @var Doctrine\ORM\EntityManagerInterface
    */
    private $em;
    
    /**
    * @var App/Service/AutorizadorService
    */
    private $autorizador;

    /**
    * @var App/Service/CarteiraDigitalService
    */
    private $carteiraDigitalService;

    /**
    * @var Symfony\Component\Messenger\MessageBusInterface
    */
    private $mensageiro;
    
    
    public function __construct(EntityManagerInterface $em, AutorizadorService $autorizador, CarteiraDigitalService $carteiraDigitalService, MessageBusInterface $mensageiro) {
        $this->em = $em;
        $this->autorizador = $autorizador;
        $this->carteiraDigitalService = $carteiraDigitalService;
        $this->mensageiro = $mensageiro;
    }
    
    
    /**
     * @todo falta incluir pessoa juridica e serviço de autorização, melhorar exceptions e retirar validações daqui
     * @return App\Entity\Transacao transação feita
     * @param App\Entity\Transacao transação a fazer
     * @throws App\Exception\NaoEncontradoException
     */
    public function transferir(Transacao $transacao): ?Transacao
    {        
        //verifica se a origem pode enviar transacao
        if($transacao->getOrigem()->getProprietario() instanceof \App\Entity\Pessoa\PessoaJuridica){
            throw new \App\Exception\TransacaoException('Carteiras de pessoas jurídicas não podem enviar transferencias');
        }

        //verifica se há saldo disponível
        if($this->carteiraDigitalService->simularTransferencia($transacao->getOrigem(), $transacao->getValor())){
            throw new \App\Exception\TransacaoException('Saldo insuficiente');
        }

        //realiza transação financeira
        $this->em->getConnection()->beginTransaction(); 
        try {
            $this->autorizador->autorizar();
            $this->carteiraDigitalService->debitar($transacao->getOrigem(), $transacao->getValor());//atualizasaldo origem
            $this->carteiraDigitalService->creditar($transacao->getDestino(), $transacao->getValor());//atualizasaldo destino 
            $this->save($transacao); //salva transacao financeira
            $this->mensageiro->dispatch(new TransacaoMessage($transacao->getId()));//enfilera notificação
            $this->em->getConnection()->commit();
            
            return $transacao;
        } catch (\Exception $e) {
            $this->em->getConnection()->rollBack();
            throw $e;
        }
    }

    private function save(Transacao $transacao) :void{            
        $this->em->persist($transacao); 
        $this->em->flush();
    }    
    
}
