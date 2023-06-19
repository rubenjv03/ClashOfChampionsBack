<?php

namespace App\Controller;

use App\Entity\Tournament;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\MatchController;

class TournamentController extends AbstractController
{
    #[Route('/tournament', name: 'app_tournament')]
    public function index(): Response
    {
        return $this->render('tournament/index.html.twig', [
            'controller_name' => 'TournamentController',
        ]);
    }


    /**
     * @Route("/tournament-register")
     */
    public function tournamentRegistration(ManagerRegistry $doctrine, Request $request){
        $tournament = json_decode($request->getContent(), true);
        $entityManager = $doctrine->getManager();
        $TournamentToRegister = new Tournament();
        $TournamentToRegister->setName($tournament['name']);
        $TournamentToRegister->setPartNum($tournament['part_num']);
        $TournamentToRegister->setDescription($tournament['description']);
        $TournamentToRegister->setDateBegin($tournament['date_begin']);
        $TournamentToRegister->setDateEnd($tournament['date_end']);
        $TournamentToRegister->setIsActive(false);
        $TournamentToRegister->setGameName($tournament['game_name']);
        $entityManager->persist($TournamentToRegister);
        $entityManager->flush();
        $matchController = new MatchController();
        $matchController->createMatch($doctrine, $TournamentToRegister->getName());
        return $this->json([
            'redirectTo' => 'http://localhost:4200/'
        ]);

    }
    /**
     * @Route("/getTournaments")
     */
    public function getTournaments(ManagerRegistry $doctrine, Request $request){
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository(Tournament::class);
        $tournaments = $repository->findNextFourTournaments();
        return $this->json($tournaments);

    }
}
