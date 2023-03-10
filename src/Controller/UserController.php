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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/login")
     */

    //PRUEBA
    public function userLogin(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->findOneBy(array('nickname' => "usuarioPrueba1")); 
        var_dump($user);
        $hash = $user->getPlayerPwd();
        echo($hash);
        //var_dump(password_get_info($hash));
        //print_r( password_verify("1234", $user->getPlayerPwd()));
        if (password_verify('1234', $hash)) {
            return new Response("contraseña correcta");
        }else{
            return new Response("Contraseña incorrecta");
        }
    }

    /*public function userLogin($userName, $userPwd, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->findOneBy(array('nickname' => $userName));
        if (password_verify($userPwd, $user->getPlayerPwd())) {
            return new Response("Login efectuado correcamente");
        }else {
            
        }


       
    }*/


    /**
     * @Route("/signin")
     */

    //FUNCIÓN DE PRUEBA
    /*public function userSignIn(ManagerRegistry $doctrine): Response
    {
        $birthDate = new DateTime('2022-01-30');
        $entityManager = $doctrine->getManager();
        $user = new User();
        $user->setNickname("usuarioPrueba1");
        $user->setMail("gBCHJBCHDVf@gmail.com");
        $user->setPlayerPwd("1234");
        $user->setBirthdate($birthDate);
        $claveDeUsuario = password_hash($user->getPlayerPwd(),PASSWORD_DEFAULT);
        $user->setPlayerPwd($claveDeUsuario);
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response("Usuario regsistrado en la base de datos correctamente");
    }   */

    //FUNCIÓN BUENA
    public function userSignIn(ManagerRegistry $doctrine, Request $request)
    {


        
        $user = json_decode($request->getContent(), true);

        //$user = json_decode(file_get_contents("php://input"));
        $entityManager = $doctrine->getManager();
        $userToRegister = new User();
        $userToRegister->setNickname($user["username"]);
        $userToRegister->setMail($user["email"]);
        $userToRegister->setPlayerPwd($user["password"]);
        $userToRegister->setBirthdate($user["birthdate"]);
        $entityManager->persist($userToRegister);
        $entityManager->flush();
        return new Response("user registered");
    }   


    //DELETE
    /**
     * @Route("/user/delete/{userNickname}")
     */
    public function deleteUser($userNickname, ManagerRegistry $doctrine){
        try {
        $repository = new UserRepository($doctrine);
        $userToDelete = $repository->findOneBy(array('nickname' => $userNickname));
        $repository->remove($userToDelete, true);
        return new Response("Usuario eliminado de la base de datos correctamente");
        } catch (\Throwable $th) {
            return new Response($th->getMessage());
        }
        
    }
    /**
     * @Route("/profile/{userNickname}")
     */
    public function viewProfile($userNickname, ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->findOneBy(array('nickname' => $userNickname)); 
        $jsonInfo = new JsonResponse(json_encode($user));
        $jsonInfo->send();
    }

    /**
     * @Route("/profile")
     */
    public function editProfile()
    {
        
    }

    
    
    
    
    
    
    
    /*#[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }*/
}
