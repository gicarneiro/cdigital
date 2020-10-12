<?php 

namespace App\Message;

class TransacaoMessage {

    private $transacaoId; //symfony doc indica passar o id ou informações relevantes ao inves de todo a entidade doctrine

    public function __construct(int $transacaoId) {
        $this->transacaoId = $transacaoId;
    }

    public function getTransacaoId(): int {
        return $this->transacaoId;
    }
}
