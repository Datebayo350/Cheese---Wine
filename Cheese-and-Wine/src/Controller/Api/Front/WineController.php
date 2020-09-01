<?php

namespace App\Controller\Api\Front;

use App\Entity\Wine;
use App\Repository\WineRepository;
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

class WineController extends AbstractController
{
    
    /**
     * Get all wines
     * 
     * @Route("/api/wines", name="wines_get", methods={"GET"})
     */
    public function getAll(WineRepository $wineRepository)
    {
        $wines = $wineRepository->findAll();

        return $this->json($wines, Response::HTTP_OK, [], ['groups' => 'wines_get']);
    }

    /**
     * Get one wine
     * 
     * @Route("/api/wine/{id}", name="wine_detail", methods={"GET"})
     */
    public function getOne(WineRepository $wineRepository, Wine $wine = null)
    {
        // En cas de 404 (id non trouvé)
        if ($wine === null) {
            // Message en JSON et status 404
            return $this->json(['error' => 'Ce vin n\'existe pas !'], Response::HTTP_NOT_FOUND);
        }

        $wine = $wineRepository->find($wine);
        //dump($wine);

        return $this->json($wine, Response::HTTP_OK, [], ['groups' => 'wine_detail']);
    }
}