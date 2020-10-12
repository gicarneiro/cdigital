<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Psr\Log\LoggerInterface;


class AutorizadorService {
    
    private $cliente;

    private $logger;

    
    public function __construct(HttpClientInterface $client, LoggerInterface $logger)
    {
        $this->cliente = $client;
        $this->logger = $logger;
    }
    /**
    * Verifica se a transferencia está autorizada, atraves de um serviço terceirizado
    */
    public function autorizar(){
        try{
            $resposta = $this->cliente->request('GET', 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6', ['timeout' => 5]);
    
            if($resposta->getStatusCode() != JsonResponse::HTTP_OK){
                $this->logger->error(json_encode(['Code' => $resposta->getStatusCode()]));
                throw new HttpException(JsonResponse::HTTP_BAD_GATEWAY, 'Serviço indisponível, por favor tente mais tarde');
            }
            
            return $resposta;
        } catch (\Exception $e) {
            $this->logger->error(json_encode(['Code' => $e->getCode(), 'mensagem' => $e->getMessage()]));
            throw new HttpException(JsonResponse::HTTP_BAD_GATEWAY, 'Serviço indisponível, por favor tente mais tarde');
        }
    }
}