<?php

namespace App\Service;

use App\Entity\CarteiraDigital;
use App\Repository\CarteiraDigitalRepository;
use App\Exception\NaoEncontradoException;

class CarteiraDigitalService
{
    
    /**
    * @var App\Repository\CarteiraDigitalRepository
    */
    private $repository;
    
    
    
    public function __construct(CarteiraDigitalRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
    * @return App\Entity\CarteiraDigital
    * @param int proprietario id
    * @throws App\Exception\NaoEncontradoException
    */
    public function getByProprietario($id) :?CarteiraDigital  {
        $carteiradigital = $this->repository->findOneBy(['proprietario' => $id]);
        if (empty($carteiradigital)) {
            throw new NaoEncontradoException('Usuário ou carteira digital não encontrados');
        }
        return $carteiradigital;
    }

    /**
    * @return App\Entity\CarteiraDigital
    * @param int carteira digital id
    * @throws App\Exception\NaoEncontradoException
    */
    public function get($id) :?CarteiraDigital  {
        $carteiradigital = $this->repository->findOneBy(['id' => $id]);
        if (empty($carteiradigital)) {
            throw new NaoEncontradoException('Carteira digital não encontrada');
        }
        return $carteiradigital;
    }
    
    public function getByProprietarioAlias($alias){
        return $this->repository->findByProprietarioAlias($alias);
    }
    
    /**
    * Verifica se é possível debitar um valor do saldo atual, sem impactar saldo
    * @return void
    * @param CarteiraDigital 
    * @param int valor 
    */
    public function simularTransferencia(CarteiraDigital $carteiraDigital, int $valor): ?int { 
        return $carteiraDigital->getSaldo() - $valor < 0;
    }
    
    /**
    * Retira valor no saldo da carteira
    * @return void
    * @param CarteiraDigital 
    * @param int valor 
    */
    public function debitar(CarteiraDigital $carteiraDigital, int $valor): void { 
        $novoSaldo = $carteiraDigital->getSaldo() - $valor;
        $carteiraDigital->setSaldo($novoSaldo);
    }
    
    /**
    * Acrescenta valor ao saldo na carteira
    * @return void
    * @param CarteiraDigital 
    * @param int valor 
    */
    public function creditar(CarteiraDigital $carteiraDigital, int $valor): void { 
        $novoSaldo = $carteiraDigital->getSaldo() + $valor;
        $carteiraDigital->setSaldo($novoSaldo);
    }
    
}
