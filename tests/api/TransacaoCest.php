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

    public function transferirParaPessoaJuridica(\ApiTester $I){   
        $transacao = [
            'value' => '10.59',
            'payer' => '1',
            'payee' => '3'
        ];     
        $I->sendPOST("/transaction", $transacao);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); 
        $I->seeResponseContainsJson(["valor" => $transacao['value']]);
    }

    public function naoTransfereSemSaldo(\ApiTester $I){
        $transacao = [
            'value' => '10000',
            'payer' => '1',
            'payee' => '2'
        ];     
        $I->sendPOST("/transaction", $transacao);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN); 
    }

    public function naoTransfereSeDestinoNaoExistir(\ApiTester $I){
        $transacao = [
            'value' => '100',
            'payer' => '1',
            'payee' => '55'
        ];     
        $I->sendPOST("/transaction", $transacao);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND); 
    }

    public function naoTransfereSeOrigemNaoExistir(\ApiTester $I){
        
        $transacao = [
            'value' => '100',
            'payer' => '55',
            'payee' => '1'
        ];     
        $I->sendPOST("/transaction", $transacao);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND); 
    }

    public function naoTransfereSeOrigemForPessoaJuridica(\ApiTester $I){
        
        $transacao = [
            'value' => '100',
            'payer' => '3',
            'payee' => '1'
        ];     
        $I->sendPOST("/transaction", $transacao);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN); 
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