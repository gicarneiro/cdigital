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
            $carteiradigital = $this->service->getByProprietario($usuario);  
            return $this->json($carteiradigital);
        } catch (NaoEncontradoException $e ) {
            return $this->json(["message" => $e->getMessage() ], JsonResponse::HTTP_NOT_FOUND);            
        }
    }
}
