<?php

class TransacaoCest{


    /**
     *  @dataProvider transacoesProvider
     */
    public function transferir(\ApiTester $I, \Codeception\Example $cdigital){        
        $I->sendPOST("/transaction", [
            'value' => $cdigital['valor'],
            'payer' => $cdigital['origem'],
            'payee' => $cdigital['destino']
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); 
        $I->seeResponseContainsJson(["valor" => $cdigital['valor']]);
    }

    public function naoTransfereSemSaldo(\ApiTester $I){
        
        $I->sendPOST("/transaction", [
            'value' => 10000,
            'payer' => 1,
            'payee' => 2
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN); 
    }

    public function naoTransfereSeDestinoNaoExistir(\ApiTester $I){
        
        $I->sendPOST("/transaction", [
            'value' => 100.00,
            'payer' => 1,
            'payee' => 55
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND); 
    }

    public function naoTransfereSeOrigemNaoExistir(\ApiTester $I){
        
        $I->sendPOST("/transaction", [
            'value' => 100.00,
            'payer' => 55,
            'payee' => 1
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND); 
    }


    /**
     * @return array
     */
    protected function transacoesProvider(){
        return [
            ['origem'=>"1", 'valor'=>100.00, 'destino' => '2'],
            ['origem'=>"2", 'valor'=>100.00, 'destino' => '1']
        ];
    }

}