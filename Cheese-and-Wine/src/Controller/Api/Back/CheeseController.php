<?php

namespace App\Controller\Api\Back;

use App\Entity\Cheese;
use App\Repository\CheeseRepository;
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
 * 
 * @Route("/api/back/cheese")
 */
class CheeseController extends AbstractController
{
    /**
     * Back-office : Cheeses list
     * 
     * @Route("/browse", name="back_cheese_browse", methods={"GET"})
     */
    public function browse(CheeseRepository $cheeseRepository)
    {
        $cheeses = $cheeseRepository->findAll();
        
        return $this->json($cheeses, Response::HTTP_OK, [], ['groups' => 'cheeses_get']);
    }

    /**
     * Back-office : Cheeses detail
     * 
     * @Route("/read/{id}", name="back_cheese_read", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read(CheeseRepository $cheeseRepository, Cheese $cheese = null)
    {
        // If the cheese is not found
        if ($cheese === null) {
            // 404 error with a message
            return $this->json(['error' => 'Fromage non trouvé.'], Response::HTTP_NOT_FOUND);
        }
        
        $cheese = $cheeseRepository->find($cheese);
        
        return $this->json($cheese, Response::HTTP_OK, [], ['groups' => 'cheeses_detail']);
        
        
    }

    /**
     * Back-office : Edit a Cheese
     * 
     * @Route("/edit/{id}", name="back_cheese_edit", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function edit(Cheese $cheese = null, EntityManagerInterface $em, SerializerInterface $serializer, Request $request)
    {
        // 1.Je modifie le fromage dont l'id est transmis via l'Url

        if ($cheese === null) {

            //On retourne un message JSON + un status 404
            return $this->json(['error' => 'Fromage non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        // 2.j'associe les données JSON recues sur l'entité existante et je désérialise les données recues depuis le front dans l'objet Cheese à modifier
        $updateData = $serializer->deserialize($request->getContent(), Cheese::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $cheese]);
        
        $em->flush();

        return $this->json(['message' => 'Fromage modifié.'], Response::HTTP_OK);
        

    }

    /**
     * Back-office : Add a Cheese
     * 
     * @Route("/add", name="back_cheese_add", methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $content = $request->getContent();

        $cheese = $serializer->deserialize($content, Cheese::class, 'json');
        //$origin = $serializer->deserialize($content, Origin::class, 'json');
        //$wine = $serializer->deserialize($content, Wine::class, 'json');

        dump($cheese);
        $errors = $validator->validate($cheese);

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
        //$entityManager->persist($wine);
        $entityManager->persist($cheese);

        $entityManager->flush();

        // Rediriger vers l'URL de la ressource avec un statut 201

        return $this->json(['message' => 'Fromage ajouté.'], Response::HTTP_OK);

  
    }

    /**
     * Back-office : Delete a Cheese
     * 
     * @Route("/delete/{id}", name="back_cheese_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Cheese $cheese = null, EntityManagerInterface $em)
    {
        // 404
        if ($cheese === null) {
            return $this->json(['error' => 'Fromage non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($cheese);
        $em->flush();

        return $this->json(['message' => 'Fromage supprimé.'], Response::HTTP_OK);

    }

}