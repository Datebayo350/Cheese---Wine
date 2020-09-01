<?php

namespace App\Controller\Api\Front;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/users", name="users_get", methods={"GET"})
     */
    public function getAll(UserRepository $userRepository)
    {
        

        return $this->json($userRepository->findAll(),Response::HTTP_OK,[],["groups" => "users_get"]);
    }
}