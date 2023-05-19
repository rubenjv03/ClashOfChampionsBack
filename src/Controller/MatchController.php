<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    #[Route('/match/controller', name: 'app_match_controller')]
    public function index(): Response
    {
        return $this->render('match_controller/index.html.twig', [
            'controller_name' => 'MatchController',
        ]);
    }

    /**
     * @Route("/match")
     */

     public function hfhic(){

     }

}
