<?php

namespace App\Controller;

use App\Entity\Transacao;
use App\Exception\NaoEncontradoException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CarteiraDigitalController extends AbstractController
{
    /**
    * @var \App\Service\CarteiraDigitalService
    */
    private $service;
    
    public function __construct(\App\Service\CarteiraDigitalService $carteiraDigitalService){
        $this->service = $carteiraDigitalService;     
    }
    
    /**
    * @Route("{usuario}/carteiradigital")
    */
    public function getAction($usuario)
    {
        try{   
            $carteiradigital = $this->service->get($usuario);  
            return $this->json($carteiradigital);
        } catch (NaoEncontradoException $e ) {
            return $this->json(["message" => $e->getMessage() ], JsonResponse::HTTP_NOT_FOUND);            
        }
    }
    
    /**
    * @todo form e validate 
    * @Route("{usuario}/carteiradigital/transferencia", methods={"POST"}, defaults={ "_format" = "json" })
    */
    public function transferirAction($usuario, Request $request){
        try{
            $carteiraDigital = $this->service->get($usuario);
            
            $transacao = new Transacao();
            $transacao->setDestinoAlias($request->get('destino'));
            $transacao->setOrigem($carteiraDigital);
            $transacao->setValor($request->get('valor'));
            
            $transferencia = $this->service->transferir($transacao);    
            
            return $this->json($transferencia);
        } catch (NaoEncontradoException $e ) {
            return $this->json(["message" => $e->getMessage() ], JsonResponse::HTTP_NOT_FOUND);            
        } catch (\App\Exception\TranasacaoException $e ) {
            return $this->json(["message" => $e->getMessage() ], JsonResponse::HTTP_FORBIDDEN);            
        }  catch (HttpException $e ) {
            return $this->json(["message" => $e->getMessage() ], JsonResponse::HTTP_BAD_GATEWAY);            
        } 
    }
}
