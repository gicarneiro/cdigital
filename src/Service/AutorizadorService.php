<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;


class AutorizadorService {
    
    private $cliente;
    
    public function __construct(HttpClientInterface $client)
    {
        $this->cliente = $client;
    }
    /**
    * Verifica se a transferencia está autorizada, atraves de um serviço terceirizado
    */
    public function autorizar(){
        $resposta = $this->cliente->request('GET', 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        
        if($resposta->getStatusCode() != JsonResponse::HTTP_OK){
            throw new HttpException($resposta->getStatusCode(), 'Serviço indisponível, por favor tente mais tarde');
        }
        
        return $resposta;
    }
}