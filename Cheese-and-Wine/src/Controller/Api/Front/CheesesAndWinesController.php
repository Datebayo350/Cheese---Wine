<?php

namespace App\Controller\Api\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cheese;
use App\Repository\CheeseRepository;
use App\Entity\Wine;
use App\Repository\WineRepository;
use Symfony\Component\HttpFoundation\Response;

class CheesesAndWinesController extends AbstractController
{
    /**
     * @Route("/api/cheesesandwines", name="cheeses_and_wines", methods={"GET"})
     */
    public function getAll(WineRepository $wineRepository, CheeseRepository $cheeseRepository)
    {
        $data1 = $wineRepository->findAll();
        $data2 =  $cheeseRepository->findAll();
      
        $data3 = array_merge($data1,$data2);
     
        dump($data3);

        
        
        return $this->json($data3,Response::HTTP_OK,[],['groups' => 'data']);
    }
}