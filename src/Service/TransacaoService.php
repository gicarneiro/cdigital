<?php

namespace App\Service;

use App\Service\CarteiraDigitalService;
use App\Entity\Transacao;
use Doctrine\ORM\EntityManagerInterface;

class TransacaoService
{
    
    
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
    
    
    public function __construct(EntityManagerInterface $em, AutorizadorService $autorizador, CarteiraDigitalService $carteiraDigitalService) {
        $this->em = $em;
        $this->autorizador = $autorizador;
        $this->carteiraDigitalService = $carteiraDigitalService;
    }
    
    
    /**
     * @todo falta incluir pessoa juridica e serviço de autorização, melhorar exceptions e retirar validações daqui
     * @return App\Entity\Transacao transação feita
     * @param App\Entity\Transacao transação a fazer
     * @throws App\Exception\NaoEncontradoException
     */
    public function transferir(Transacao $transacao): ?Transacao
    {        
        //verifica é a origem pode enviar transacao
        if($transacao->getOrigem()->getProprietario() instanceof \App\Entity\Pessoa\PessoaJuridica){
            throw new \App\Exception\TransacaoException('Carteiras de pessoas jurídicas não podem enviar transferencias');
        }

        //verifica se há saldo disponível
        if($this->carteiraDigitalService->simularTransferencia($transacao->getOrigem(), $transacao->getValor())){
            throw new \App\Exception\TransacaoException('Saldo insuficiente');
        }


        //realiza transação financeira
        $this->em->getConnection()->beginTransaction(); //poderia deixar implicio no flush
        try {
            $this->autorizador->autorizar();
            $this->carteiraDigitalService->debitar($transacao->getOrigem(), $transacao->getValor());//atualizasaldo origem
            $this->carteiraDigitalService->creditar($transacao->getDestino(), $transacao->getValor());//atualizasaldo destino 
            $this->em->persist($transacao->getOrigem());       
            $this->em->persist($transacao->getDestino());       
            $this->em->persist($transacao); //salva transacao financeira
            $this->em->flush();
            $this->em->getConnection()->commit();
            
            return $transacao;
        } catch (\Exception $e) {
            $this->em->getConnection()->rollBack();
            throw $e;
        }
    }
    
    
}
