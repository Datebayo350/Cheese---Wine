<?php

namespace App\Controller\Api\Back;

use App\Entity\Wine;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * BREAD method
 * @Route("/api/back/wine")
 */
class WineController extends AbstractController
{
    /**
     * Back-office : Wines list
     * 
     * @Route("/browse", name="back_wine_browse", methods={"GET"})
     */
    public function browse(WineRepository $wineRepository)
    {
        $wines = $wineRepository->findAll();
        
        return $this->json($wines, Response::HTTP_OK, [], ['groups' => 'wines_get']);
    }

    /**
     * Back-office : Wines detail
     * 
     * @Route("/read/{id}", name="back_wine_read", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read(WineRepository $wineRepository, Wine $wine = null)
    {
        // If the Wine is not found
        if ($wine === null) {
            // 404 error with a message
            return $this->json(['error' => 'Vin non trouvé.'], Response::HTTP_NOT_FOUND);
        }
        
        $wine = $wineRepository->find($wine);
        
        return $this->json($wine, Response::HTTP_OK, [], ['groups' => 'wine_detail']);
        
    }

    /**
     * Back-office : Edit a Wine
     * 
     * @Route("/edit/{id}", name="back_wine_edit", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function edit(Wine $wine = null, EntityManagerInterface $em, SerializerInterface $serializer, Request $request)
    {
        // 1.Je modifie le Vin dont l'id est transmis via l'Url

        if ($wine === null) {

            //On retourne un message JSON + un status 404
            return $this->json(['error' => 'Vin non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        // 2.j'associe les données JSON recues sur l'entité existante et je désérialise les données recues depuis le front dans l'objet Wine à modifier
        $updateData = $serializer->deserialize($request->getContent(), Wine::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $wine]);
        
        $em->flush();

        return $this->json(['message' => 'Vin modifié.'], Response::HTTP_OK);
        

    }

    /**
     * Back-office : Add a Wine
     * 
     * @Route("/add", name="back_Wine_add", methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $content = $request->getContent();

        $wine = $serializer->deserialize($content, Wine::class, 'json');
        //$origin = $serializer->deserialize($content, Origin::class, 'json');
        //$cheese = $serializer->deserialize($content, Cheese::class, 'json');


        $errors = $validator->validate($wine);

        if(count($errors) > 0 ) {
            $errorsArray = [];
            
            foreach ($errors as $error){
                
                // Ici on crée un tableau associatif dont la clé est la propriété en erreur
                // et qui contient un tableau dont les éléments sont les messages d'erreur de la propriété concernée
                // $errorsArray = [
                //     'title' => [
                //         'erreur 1',
                //         'erreur 2',
                //     ],
                //     'email' => []
                // ];   
                $errorsArray[$error->getPropertyPath()][]  = $error->getMessage();
            }
            
         
            return $this->json($errorsArray, Response::HTTP_UNPROCESSABLE_ENTITY);
            
            // On aurait pu également renvoyer tout le tableau d'objet en JSON
            //return $this->json($errors, 400);
        }
        
        // Flusher via le manager
        $entityManager = $this->getDoctrine()->getManager();
        //$entityManager->persist($origin);
        $entityManager->persist($wine);
        //$entityManager->persist($cheese);

        $entityManager->flush();

        // Rediriger vers l'URL de la ressource avec un statut 201

        return $this->json(['message' => 'Vin ajouté.'], Response::HTTP_OK);

  
    }

    /**
     * Back-office : Delete a Wine
     * 
     * @Route("/delete/{id}", name="back_wine_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Wine $wine = null, EntityManagerInterface $em)
    {
        // 404
        if ($wine === null) {
            return $this->json(['error' => 'Vin non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($wine);
        $em->flush();

        return $this->json(['message' => 'Vin supprimé.'], Response::HTTP_OK);

    }

}