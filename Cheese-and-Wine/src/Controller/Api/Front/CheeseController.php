<?php

namespace App\Controller\Api\Front;

use App\Entity\Cheese;
use App\Repository\CheeseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class CheeseController extends AbstractController
{
    /**
     * Get all cheeses
     * 
     * @Route("/api/cheeses", name="cheeses_get", methods={"GET"})
     */
    public function getAll(CheeseRepository $cheeseRepository)
    {
        // 1. La fonction json(), va normalizer le tableau d'objets en tableau associatif simple, puis encoder le resultat en JSON
        // 2. La fonction attends des paramètres : 
        /*  
            -les données qu'on veux utiliser 
            -Le status souhaité
            -Un tableau permettant de préciser la nature des données, et en quoi on veux les transformer, pas besoin ici car json() le fait seul
            -Les infos uniquement pour les propriétés taguées 'cheeses_get'
            ATTENTION : Ne pas taguer les propriétés faisant appel à d'autres tables ex: wines, origin. 
        */
        // 3. La fonction retourne du JSON.
        $cheeses = $cheeseRepository->findAll();
        
        return $this->json($cheeses, Response::HTTP_OK, [], ['groups' => 'cheeses_get']);

    }

    /**
     * Get one Cheese
     * 
     * @Route("/api/cheese/{id}", name="cheese_detail", methods={"GET"})
     */
    public function getOne(CheeseRepository $cheeseRepository, Cheese $cheese = null)
    {
        // En cas de 404 (id non trouvé)
        if ($cheese === null) {
            // Message en JSON et status 404
            return $this->json(['error' => 'Ce fromage n\'existe pas !'], Response::HTTP_NOT_FOUND);
        }

        $cheese = $cheeseRepository->find($cheese);
        //dump($cheese);

        return $this->json($cheese, Response::HTTP_OK, [], ['groups' => 'cheeses_detail']);
    }
  
}