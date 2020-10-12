<?php

namespace App\Controller;

use App\Entity\Transacao;
use App\Exception\NaoEncontradoException;
use App\Service\CarteiraDigitalService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TransacaoController extends AbstractController {
    
    /**
    * @var \App\Service\TransacaoService
    */
    private $service;

    /**
    * @var \App\Service\CarteiraDigitalService
    */
    private $CarteiraDigitalService;
    
    public function __construct(\App\Service\TransacaoService $transacaoServiceService, CarteiraDigitalService $carteiraDigitalService){
        $this->service = $transacaoServiceService;     
        $this->carteiraDigitalService = $carteiraDigitalService;     
    }

    /**
    * @todo form e validate e trnasferir a recuperação das carteiras para lá
    * @Route("transaction", methods={"POST"}, defaults={ "_format" = "json" })
    */
    public function transferirAction(Request $request){
        try{

            $transacao = new Transacao();
            $transacao->setOrigem($this->carteiraDigitalService->get($request->get('payer')));
            $transacao->setDestino($this->carteiraDigitalService->get($request->get('payee')));
            $transacao->setValor($request->get('value'));
            
            $transferencia = $this->service->transferir($transacao);    
            
            return $this->json($transferencia);
        } catch (NaoEncontradoException $e ) {
            return $this->json(["message" => $e->getMessage() ], JsonResponse::HTTP_NOT_FOUND);            
        } catch (\App\Exception\TransacaoException $e ) {
            return $this->json(["message" => $e->getMessage() ], JsonResponse::HTTP_FORBIDDEN);            
        }  catch (HttpException $e ) {
            return $this->json(["message" => $e->getMessage() ], JsonResponse::HTTP_BAD_GATEWAY);            
        } 
    }
}