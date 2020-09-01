<?php

namespace App\Controller\Api\Front;

use App\Entity\UserProposal;
use App\Repository\UserProposalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserProposalController extends AbstractController
{
    /**
     * Get all proposition 
     * 
     * @Route("/api/userproposal", name="user_proposal_get", methods={"GET"})
     */
    public function getAll(UserProposalRepository $userProposalRepository)
    {

        $userProposal = $userProposalRepository->findAll();

        return $this->json($userProposal, Response::HTTP_OK, [], ['groups' => 'user_proposal_get']);
    }

    /**
     * Add a proposition 
     * 
     * @Route ("/api/userproposal/add", name="user_proposal_add", methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $content = $request->getContent();

        $user = $serializer->deserialize($content, UserProposal::class, 'json');

        $errors = $validator->validate($user);

        if(count($errors) > 0 ) {
            $errorsArray = [];

            foreach ($errors as $error){
                
                $errorsArray[$error->getPropertyPath()][] = $error->getMessage();
            }
            return $this->json($errorsArray, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($user);

        $entityManager->flush();

        return $this->RedirectToRoute('user_proposal_get',['id' => $user->getId()], Response::HTTP_CREATED );
    }
}