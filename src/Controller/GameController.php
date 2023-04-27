<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
    /**
     * @Route("/game-register")
     */
    public function gameRegistration(ManagerRegistry $doctrine, Request $request){
        $game = json_decode($request->getContent(), true);

        //$user = json_decode(file_get_contents("php://input"));
        $entityManager = $doctrine->getManager();
        $GameToRegister = new Game();
        $GameToRegister->setGameName($game["game_name"]);
        $GameToRegister->setGamePlatform($game["game_platform"]);
        $GameToRegister->setGameFormat($game["game_format"]);
        $GameToRegister->setGameDescription($game["game_description"]);
        $GameToRegister->setGameImg($game["game_img"]);
        $entityManager->persist($GameToRegister);
        $entityManager->flush();
        return $this->json([
            'redirectTo' => 'http://localhost:4200/'
        ]);
    }
}
