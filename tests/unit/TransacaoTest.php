<?php

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

class TransacaoTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before(){
    }

    protected function _after(){
    }

    private function getContainer($service){
        return $this->getModule('Symfony')->_getContainer()->get($service);
    }

    public function testTranferir() {

        // //cenario aplicação
        // $em = $this->getContainer('Doctrine\ORM\EntityManagerInterface');
        // $autorizadorService = $this->make(\App\Service\AutorizadorService::class, [
        //     'autorizar' => function() {
        //         throw new HttpException(JsonResponse::HTTP_REQUEST_TIMEOUT, 'Serviço indisponível, por favor tente mais tarde');
        //     } ]);
        // $carteiraDigitalService = $this->make(\App\Service\CarteiraDigitalService::class, [
        //     'creditar' => function() {}, 
        //     'debitar' => function() {}, 
        //     ]);
        // $transacao = $this->construct($em, $autorizadorService, $carteiraDigitalService);
        
        // //cenário dados
        // $carteiraOrigem = new \App\Entity\CarteiraDigital();
        // $carteiraOrigem = new \App\Entity\CarteiraDigital();
        // $carteiraDestino = new \App\Entity\CarteiraDigital();
        // $transacao = new \App\Entity\Transacao();
        // $transacao->setOrigem($carteiraOrigem);
        // $transacao->setDestino($carteiraDestino);
        // $transacao->setValor(100.00);

        // //executando
        // $transacao->transferir($transacao);

        //espero que dê exceção de fora do ar
    }
}