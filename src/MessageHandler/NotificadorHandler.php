<?php

namespace App\MessageHandler;

use App\Entity\Transacao;
use App\Message\TransacaoMessage;
use App\Repository\TransacaoRepository;
use App\Service\NotificadorService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Psr\Log\LoggerInterface;

class NotificadorHandler implements MessageHandlerInterface {

    private $transacaoRepository;
    private $notificador;
    private $logger;
    private $mensageiro;

    public function __construct(TransacaoRepository $transacaoRepository, NotificadorService $notificador, LoggerInterface $logger, MessageBusInterface $mensageiro)
    {
        $this->transacaoRepository = $transacaoRepository;
        $this->notificador = $notificador;
        $this->logger = $logger;
        $this->mensageiro = $mensageiro;
    }

    public function __invoke(TransacaoMessage $transacaoMessage) {
        try{
            $transacao = $this->transacaoRepository->find($transacaoMessage->getTransacaoId());
            $this->notificador->notificar();
            $this->logger->info('Transação - Notificação enviada: '. json_encode($transacao->getInfo()));
        } catch (\Exception $e){
            $this->mensageiro->dispatch($transacaoMessage);//reenfilera notificação
            $this->logger->error(json_encode(['Code' => $e->getCode(), 'Mensagem' => $e->getMessage(), 'Transacao' => $transacaoMessage->getTransacaoId()]));
        }
    }
}