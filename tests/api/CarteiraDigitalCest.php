<?php

class CarteiraDigitalCest{

    /* */

    /**
     *  @dataProvider carteirasdigitaisProvider
     */
    public function verificarSaldoNaCarteira(\ApiTester $I, \Codeception\Example $cdigital){
        
        $I->sendGET("/{$cdigital['proprietario']}/carteiradigital", []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); 
        $I->seeResponseContainsJson(["saldo" => $cdigital['saldo']]);
    }

    /**
     * @todo melhorar criação dos cenários
     */
    public function exceptionQuandoCarteiraNaoExiste(\ApiTester $I){
        
        $I->sendGET("/55/carteiradigital", []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND); 
    }


    /**
     * @return array
     */
    protected function carteirasdigitaisProvider(){
        return [
            ['proprietario'=>"1", 'saldo'=>200, 'cpf' => '13373486785'],
            ['proprietario'=>"2", 'saldo'=>500, 'cpf' => '12345678901']
        ];
    }

}