<?php

namespace App\Exception;

class TranasacaoException extends \Exception{

    public function __construct($mensagem){
      parent::__construct($mensagem); 
    }
}