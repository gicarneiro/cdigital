<?php

namespace App\Service;

use App\Entity\CarteiraDigital;
use App\Entity\Transacao;
use App\Repository\CarteiraDigitalRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Exception\NaoEncontradoException;

class CarteiraDigitalService
{
    
    /**
    * @var App\Repository\CarteiraDigitalRepository
    */
    private $repository;
    
    /**
    * @var Doctrine\ORM\EntityManagerInterface
    */
    private $em;
    
    /**
    * @var App/Service/AutorizadorService
    */
    private $autorizador;
    
    
    public function __construct(CarteiraDigitalRepository $repository, EntityManagerInterface $em, AutorizadorService $autorizador)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->autorizador = $autorizador;
    }
    
    /**
     * @return App\Entity\CarteiraDigital
     * @param int carteira id
     * @throws App\Exception\NaoEncontradoException
     */
    public function get($id)
    {
        $carteiradigital = $this->repository->find($id);
        if (empty($carteiradigital)) {
            throw new NaoEncontradoException('Carteira digital ou usuário não encontrados');
        }
        return $carteiradigital;
    }
    
    /**
     * @todo falta incluir pessoa juridica e serviço de autorização, melhorar exceptions e retirar validações daqui
     * @return App\Entity\Transacao transação feita
     * @param App\Entity\Transacao transação a fazer
     * @throws App\Exception\NaoEncontradoException
     */
    public function transferir(Transacao $transacao): ?Transacao
    {
        //pegar destino
        $destino = $this->repository->findByProprietarioAlias($transacao->getDestinoAlias());
        if(empty($destino)){
            throw new NaoEncontradoException('Destino não encontrado');
        }
        $transacao->setDestino($destino);
        
        //verifica se há saldo disponível
        if($this->simularTransferencia($transacao->getOrigem(), $transacao->getValor())){
            throw new \App\Exception\TranasacaoException('Saldo insuficiente');
        }
        //realiza transação financeira
        $this->em->getConnection()->beginTransaction(); //poderia deixar implicio no flush
        try {
            $this->autorizador->autorizar();
            $this->debitar($transacao->getOrigem(), $transacao->getValor());//atualizasaldo origem
            $this->creditar($transacao->getDestino(), $transacao->getValor());//atualizasaldo destino 
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
    
     /**
     * Verifica se é possível debitar um valor do saldo atual, sem impactar saldo
     * @return void
     * @param CarteiraDigital 
     * @param int valor 
     */
    private function simularTransferencia(CarteiraDigital $carteiraDigital, int $valor): ?int { 
        return $carteiraDigital->getSaldo() - $valor >= 0;
    }
    
    /**
     * Retira valor no saldo da carteira
     * @return void
     * @param CarteiraDigital 
     * @param int valor 
     */
    private function debitar(CarteiraDigital $carteiraDigital, int $valor): void { 
        $novoSaldo = $carteiraDigital->getSaldo() - $valor;
        $carteiraDigital->setSaldo($novoSaldo);
    }
    
    /**
     * Acrescenta valor ao saldo na carteira
     * @return void
     * @param CarteiraDigital 
     * @param int valor 
     */
    private function creditar(CarteiraDigital $carteiraDigital, int $valor): void { 
        $novoSaldo = $carteiraDigital->getSaldo() + $valor;
        $carteiraDigital->setSaldo($novoSaldo);
    }
    
}
