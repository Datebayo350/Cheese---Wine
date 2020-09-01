<?php

namespace App\Controller\Api\Back;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/api/back/user")
 */
class UserController extends AbstractController
{
    // Property to get the encoder
    private $encoder;

    // Get the encoder service in the Construct function
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    /**
     * Get all users
     * 
     * @Route("/browse", name="back_user_browse", methods={"GET"})
     */
    public function browse(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        
        return $this->json($users, Response::HTTP_OK, [], ['groups'=>'users_get']);
    
 
    }

    /**
     * Get one user
     * 
     * @Route("/read/{id}", name="back_user_read", methods={"GET"}, requirements={"id"="\d+"})
     *
     */
    public function read(User $user = null){

        if ($user === null) {
            return $this->json(['error'=>'User non trouvé.'], Response::HTTP_NOT_FOUND);

        }

        return $this->json($user, Response::HTTP_OK,[], ['groups'=>'user_detail']);

    }
     
    /**
     * Back-office : Edit a user
     * 
     * @Route("/edit/{id}", name="back_user_edit", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function edit(User $user = null, EntityManagerInterface $em, SerializerInterface $serializer, Request $request)
    {
        // 1.Je modifie le Vin dont l'id est transmis via l'Url

        if ($user === null) {

            //On retourne un message JSON + un status 404
            return $this->json(['error' => 'User non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        // 2.j'associe les données JSON recues sur l'entité existante et je désérialise les données recues depuis le front dans l'objet user à modifier
        $updateData = $serializer->deserialize($request->getContent(), user::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);

        // To encode a new user's password
        $encodeUserPassword = $this->encoder->encodePassword($user, $user->getPassword());

        $user->setPassword($encodeUserPassword);
        
        $em->flush();

        return $this->json(['message' => 'User modifié.'], Response::HTTP_OK);
        

    }

    /**
     * Back-office : Add a user
     * 
     * @Route("/add", name="back_user_add", methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $content = $request->getContent();

        $user = $serializer->deserialize($content, user::class, 'json');

        // To encode a new user's password
        $encodeUserPassword = $this->encoder->encodePassword($user, $user->getPassword());

        $user->setPassword($encodeUserPassword);

        $errors = $validator->validate($user);

        if(count($errors) > 0 ) {
            $errorsArray = [];
            
            foreach ($errors as $error){
                  
                $errorsArray[$error->getPropertyPath()][]  = $error->getMessage();
            }
            
         
            return $this->json($errorsArray, Response::HTTP_UNPROCESSABLE_ENTITY);
            
            // On aurait pu également renvoyer tout le tableau d'objet en JSON
            //return $this->json($errors, 400);
        }
        
        // Flusher via le manager
        $entityManager = $this->getDoctrine()->getManager();
        
        $entityManager->persist($user);

        $entityManager->flush();

        // Rediriger vers l'URL de la ressource avec un statut 201

        //return $this->RedirectToRoute('back_user_read',['id' => $user->getId()], Response::HTTP_CREATED );
        return $this->json(['message' => 'User ajouté.'], Response::HTTP_OK);

  
    }

    /**
     * Back-office : Delete a user
     * 
     * @Route("/delete/{id}", name="back_user_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(user $user = null, EntityManagerInterface $em)
    {
        // 404
        if ($user === null) {
            return $this->json(['error' => 'User non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($user);
        $em->flush();

        return $this->json(['message' => 'User supprimé.'], Response::HTTP_OK);

    }
}