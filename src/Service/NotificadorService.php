<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Psr\Log\LoggerInterface;


class NotificadorService {
    
    private $cliente;

    private $logger;

    
    public function __construct(HttpClientInterface $client, LoggerInterface $logger)
    {
        $this->cliente = $client;
        $this->logger = $logger;
    }
    /**
    * Notifica proprietário da carteira digital ao receber transferencia, atraves de um serviço terceirizado
    */
    public function notificar(){
        try{
            $resposta = $this->cliente->request('GET', 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04', ['timeout' => 5]);
    
            if($resposta->getStatusCode() != JsonResponse::HTTP_OK){
                $this->logger->error(json_encode(['Code' => $resposta->getStatusCode()]));
                throw new HttpException(JsonResponse::HTTP_BAD_GATEWAY, 'Serviço indisponível, por favor tente mais tarde');
            }
            
            return $resposta;
        } catch (\Exception $e) {
            $this->logger->error(json_encode(['Code' => $e->getCode(), 'Mensagem' => $e->getMessage()]));
            throw new HttpException(JsonResponse::HTTP_BAD_GATEWAY, 'Serviço indisponível, por favor tente mais tarde');
        }
    }
}