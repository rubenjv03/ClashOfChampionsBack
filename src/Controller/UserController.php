<?php

namespace App\Controller;

header("Access-Control-Allow-Origin: http://localhost:4200/register");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Headers");
header("Access-Control-Allow-Methods: GET, POST OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

use App\Entity\User;
use DateTime;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends AbstractController
{
    /**
     * @Route("/login")
     */

    //PRUEBA
    public function userLogin(ManagerRegistry $doctrine, Request $request, Session $session)
    {
        $session->invalidate();
        $userToLogin = json_decode($request->getContent(), true);
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->findOneBy(array('mail' => $userToLogin["email"]));
        $hash = $user->getPlayerPwd();
        //var_dump(password_get_info($hash));
        //print_r( password_verify("1234", $user->getPlayerPwd()));
        if (password_verify($userToLogin["password"], $hash)) {
            $session = new Session();
            $session->start();
            $session->set("nickname", $user->getNickname());
            return $this->json([
                'redirectTo' => 'http://localhost:4200/'
            ]);
        } else {
            return new Response("username or password are incorrect", 401);
        }
    }


    /**
     * @Route("/logout")
     */
    public function logout(Session $session)
    {
        if ($session->isStarted()) {
            $session->invalidate();
        }
        return $this->json([
            'redirectTo' => 'http://localhost:4200/'
        ]);
    }





    /**
     * @Route("/signin")
     */
    public function userSignIn(ManagerRegistry $doctrine, Request $request)
    {
        $user = json_decode($request->getContent(), true);
    
        // Verificar la edad del usuario
        $birthdate = new DateTime($user["birthdate"]);
        $now = new DateTime();
        $interval = $now->diff($birthdate);
        $age = $interval->y;
    
        if ($age < 16) {
            return new Response("Debes tener al menos 16 años para registrarte", 400);
        }
    
        // Registrar al usuario
        $entityManager = $doctrine->getManager();
        $userToRegister = new User();
        $userToRegister->setNickname($user["username"]);
        $userToRegister->setMail($user["email"]);
        $pwd = password_hash($user["password"], PASSWORD_DEFAULT);
        $userToRegister->setPlayerPwd($pwd);
        // Convertir DateTime a string
        $birthdateString = $birthdate->format('Y-m-d');
        $userToRegister->setBirthdate($birthdateString);
        $entityManager->persist($userToRegister);
        $entityManager->flush();
        $session = new Session();
        $session->start();
        $session->set("nickname", $userToRegister->getNickname());
        return $this->json([
            'redirectTo' => 'http://localhost:4200/'
        ]);
    }
    
     


    //DELETE
    /**
     * @Route("/user/delete/{userNickname}")
     */
    public function deleteUser($userNickname, ManagerRegistry $doctrine, Request $request)
    {
        try {
            $repository = new UserRepository($doctrine);
            $userToDeleteData = json_decode($request->getContent(), true);
            $userToDelete = $repository->findOneBy(array('nickname' => $userToDeleteData[""]));
            $repository->remove($userToDelete, true);
            return new Response("Usuario eliminado de la base de datos correctamente");
        } catch (\Throwable $th) {
            return new Response($th->getMessage());
        }
    }
    /**
     * @Route("/profile/")
     */

    // public function viewProfile(ManagerRegistry $doctrine)
    // {   
    //     $repository = $doctrine->getRepository(User::class);
    //     echo($_SESSION["username"]);
    //     $user = $repository->findOneBy(array('nickname' => $_SESSION["username"])); 
    //     return new JsonResponse(json_encode($user));

    // }


    public function viewProfile(Session $session, ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(User::class);
        $username = $session->get('nickname');
        $user = $repository->findOneBy(array('nickname' => $username));
        $userData = array("id" => $user->getId(), "nickname" => $user->getNickname(), "mail" => $user->getMail(), "player_pwd" => "", "birthdate" => $user->getBirthdate());
        return $this->json($userData);
    }

    /**
     * @Route("/profile-edit")
     */
    public function editProfile(Request $request,  ManagerRegistry $doctrine, Session $session)
    {
        // if(isset($_POST["submit-button"])){
        //     return $_POST["textUser"];
        // }
        try {
            $entityManager = $doctrine->getManager();
            $repository = $doctrine->getRepository(User::class);
            $username = $session->get('nickname');
            $user = $repository->findOneBy(array('nickname' => $username));
            $newData = json_decode($request->getContent(), true);
            $newName = $newData["newName"];
            $newEmail = $newData["newEmail"];
            $newRegion = $newData["newRegion"];
            $newPassword = $newData["newPassword"];
            if ($newName != "") {
                $session->set('nickname', $newName);
                $user->setNickname($newName);
            }
            if ($newEmail != "") {
                $user->setMail($newEmail);
            }
            if ($newPassword != "") {
                $user->setPlayerPwd($newPassword);
            }
            $entityManager->flush();
            return new Response("Usuario actualizado con éxito");
        } catch (\Throwable $th) {
            return new Response($th->getMessage());
        }
    }

    /**
     * @Route("/checkSession")
     */
    public function checkSession(Session $session)
    {
        if ($session->has('nickname')) {
            return $this->json(['isLogged'=>true]);
        } else {
            return $this->json(['isLogged'=>false]);
        }
    }





    /*#[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }*/
}
