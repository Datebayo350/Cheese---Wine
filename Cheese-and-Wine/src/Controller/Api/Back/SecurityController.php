<?php

namespace App\Controller\Api\Back;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    //test
    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     * 
     */
    /*public function login(EntityManagerInterface $em)
    {
        $user = $this->getUser();
        
        // Create a unique token hashed
        $user->setApiToken(md5(uniqid())); 

        $em->flush();
        
        return $this->json([
            'name' => $user->getName(),
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
            'apiToken' => $user->getApiToken()
        ]);
    }*/
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
    
    /**
     * @Route("/api/islogged", name="api_islogged", methods={"GET"})
     */
    public function isLogged(Request $request, UserRepository $userRepository)
    {
        
        $apiToken = $request->headers->get('X-AUTH-TOKEN');  
        
        
        dd($request);

        if($apiToken === null){
            return $this->json([
                'logged' => false
            ]);
        }

        $user = $userRepository->findBy(['apiToken' => $apiToken]);

        return $this->json($user, 200, [], ['groups' => 'user_detail']);
    }
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
      
        dd($_COOKIE);
        //! Si on ne set pas le contenu = erreur 500
        //$user->eraseCredentials
        //return $response->setcontent('<h1> Deconnexion Réussie');
        
    }
    
    /**
     * @Route("/api/logout", name="api_logout", methods={"POST"})
     */
   /* public function logout(EntityManagerInterface $em)
    {
        // Effacera le token en BDD après la deconnexion de l'user
        
       $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }
        $user->setApiToken(null);
        $em->persist($user);
        
        $em->flush();  

        return New JsonResponse([
            'message' => 'Deconnexion réussie']);

    }*/
}