<?php

namespace App\Exception;

class NaoEncontradoException extends \Exception{
  
    public function __construct($mensagem){
        parent::__construct($mensagem); 
    }
}