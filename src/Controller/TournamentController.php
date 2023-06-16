<?php

namespace App\Controller;

use App\Entity\Tournament;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
        $tournament = json_decode($request->getContent());
        $entityManager = $doctrine->getManager();
        $TournamentToRegister = new Tournament();
        $TournamentToRegister->setName($tournament['name']);
        $TournamentToRegister->setPartNum($tournament['participants']);
        $TournamentToRegister->setDescription($tournament['description']);
        $TournamentToRegister->setDateBegin($tournament['date_begin']);
        $TournamentToRegister->setDateEnd($tournament['date_end']);
        $TournamentToRegister->setIsActive(false);
        $TournamentToRegister->setGameName($tournament['gameName']);
        $entityManager->persist($TournamentToRegister);
        $entityManager->flush();

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
