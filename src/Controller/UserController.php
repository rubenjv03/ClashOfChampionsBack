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

class UserController extends AbstractController
{
    /**
     * @Route("/login")
     */

    //PRUEBA
    public function userLogin(ManagerRegistry $doctrine, Request $request)
    {   
        $userToLogin = json_decode($request->getContent(), true);
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->findOneBy(array('mail' => $userToLogin["email"]));
        $hash = $user->getPlayerPwd();
        //var_dump(password_get_info($hash));
        //print_r( password_verify("1234", $user->getPlayerPwd()));
        if (password_verify($userToLogin["password"], $hash)) {
            session_start();
            $_SESSION["username"]=$user->getNickname();
            return $this->json([
                'redirectTo' => 'http://localhost:4200/'
            ]);
        }else{
            return new Response("username or password are incorrect", 401);
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

    public function userSignIn(ManagerRegistry $doctrine, Request $request)
    {        
        $user = json_decode($request->getContent(), true);

        //$user = json_decode(file_get_contents("php://input"));
        $entityManager = $doctrine->getManager();
        $userToRegister = new User();
        $userToRegister->setNickname($user["username"]);
        $userToRegister->setMail($user["email"]);
        $pwd = password_hash($user["password"], PASSWORD_DEFAULT); 
        $userToRegister->setPlayerPwd($pwd);
        $userToRegister->setBirthdate($user["birthdate"]);
        $entityManager->persist($userToRegister);
        $entityManager->flush();
        return new Response("user registered");
    }   


    //DELETE
    /**
     * @Route("/user/delete/{userNickname}")
     */
    public function deleteUser($userNickname, ManagerRegistry $doctrine, Request $request){
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
    public function viewProfile(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->findOneBy(array('nickname' => $_SESSION["username"])); 
        return new JsonResponse(json_encode($user));

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
