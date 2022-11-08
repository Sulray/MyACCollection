<?php

namespace App\Controller;

use App\Entity\Personality;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class PersonalityController extends AbstractController
{

    #[Route('/personality', name: 'app_village')]
    public function index(): Response
    {
        return $this->render('personality/index.html.twig', [
            'controller_name' => 'PersonalityController',
        ]);
    }

    /**
     * Lists all personality entities.
     *
     * @Route("/personality-list", name = "personality_list", methods="GET")
     * @Route("/personality-index", name = "personality_index", methods="GET")

     */
    public function listPersonality(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $personalities = $entityManager->getRepository(Personality::class)->findAll();

        dump($personalities);

        return $this->render('personality/index.html.twig',
            [ 'personalities' => $personalities ]
        );
    }

    /**
     * Show a personality
     *
     * @Route("/personality/{id}", name="personality_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *
     * @param Integer $id
     */
    public function showPersonality(ManagerRegistry $doctrine, $id)
    {
        $personalityRepo = $doctrine->getRepository(Personality::class);
        $personality = $personalityRepo->find($id);

        if (!$personality) {
            throw $this->createNotFoundException('The personality does not exist');
        }

        return $this->render('personality/show.html.twig',
            [ 'personality' => $personality ]
        );

    }

}
