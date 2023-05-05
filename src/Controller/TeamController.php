<?php

namespace App\Controller;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    #[Route('/team', name: 'app_team')]
    public function index(): Response
    {
        return $this->render('team/index.html.twig', [
            'controller_name' => 'TeamController',
        ]);

        
    }
    /**
     * @Route("/register-team")
     */
    public function registerTeam(ManagerRegistry $doctrine, Request $request, Session $session){

        $team = json_decode($request->getContent(), true);

        //$user = json_decode(file_get_contents("php://input"));
        $entityManager = $doctrine->getManager();
        $teamToRegister = new Team();
        $teamToRegister->setTeamname($team["teamname"]);
        $teamToRegister->setAbbreviation($team["abbreviation"]);
        $teamToRegister->setTeamDescription($team["description"]);
        $entityManager->persist($teamToRegister);
        $entityManager->flush();
        //$session = new Session();
        //$session->start();
        $session->set("team", $teamToRegister->getTeamName());
        return $this->json([
            'redirectTo' => 'http://localhost:4200/'
        ]);
    }
    }


