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


class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     * 
     */
    public function login(EntityManagerInterface $em)
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
     * @Route("/api/logout", name="api_logout", methods={"POST"})
     */
    public function logout(EntityManagerInterface $em)
    {
        // Effacera le token en BDD après la deconnexion de l'user
        
/*       $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }
        $user->setApiToken(null);
        $em->persist($user);
        
        $em->flush();  */

        return New JsonResponse([
            'message' => 'Deconnexion réussie']);

    }
}