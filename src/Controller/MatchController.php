<?php

namespace App\Controller;
use App\Entity\Tournament;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MatchGame;
use Symfony\Component\HttpFoundation\Session\Session;

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

    public function createMatch(ManagerRegistry $doctrine, $TournamentName){
        $newMatch = new MatchGame();
        $entityManager = $doctrine->getManager();
        $tournamentRepository = $entityManager->getRepository(Tournament::class);
        $tournament = $tournamentRepository->findOneBy(array('name' => $TournamentName));
        $newMatch->setTournamentId($tournament->getId());
        $newMatch->setTimeStart($tournament->getDateBegin());
        $newMatch->setTimeMax($tournament->getDateEnd());
        $entityManager->persist($newMatch);
        $entityManager->flush();
    }

    /**
     * @Route("/register-participant")
     */
    public function registerParticipant(ManagerRegistry $doctrine, Request $request, Session $session){
        $tournament = json_decode($request->getContent());
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository(MatchGame::class);
        $match = $repository->findOneBy(array('tournament_id' => $tournament));
            if($match->getParticipant1Name() == null){
                $match->setParticipant1Name($session->get('nickname'));
            }else{
                $match->setParticipant2Name($session->get('nickname'));
            }
            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                // Aquí puedes manejar la excepción, por ejemplo, registrándola
                error_log($e->getMessage());
            }
            return $this->json([
                'redirectTo' => 'http://localhost:4200/match/id'
            ]);
        }
        
    }

