<?php

namespace App\Exception;

class TransacaoException extends \Exception{

    public function __construct($mensagem){
      parent::__construct($mensagem); 
    }
}