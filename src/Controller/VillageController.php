<?php

namespace App\Controller;

use App\Entity\Village;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class VillageController extends AbstractController
{
    /**
     * @Route("/", name = "home", methods="GET")
     */
    public function indexAction()
    {
        return $this->render('index.html.twig',
            [ 'welcome' => "Have a nice use of the village list" ]
        );
    }

    #[Route('/village', name: 'app_village')]
    public function index(): Response
    {
        return $this->render('village/index.html.twig', [
            'controller_name' => 'VillageController',
        ]);
    }

    /**
     * Lists all village entities.
     *
     * @Route("/list", name = "village_list", methods="GET")
     * @Route("/index", name = "village_index", methods="GET")

     */
    public function listVillage(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $villages = $entityManager->getRepository(Village::class)->findAll();

        dump($villages);

        return $this->render('village/index.html.twig',
            [ 'villages' => $villages ]
        );
    }

    /**
     * Show a village
     *
     * @Route("/village/{id}", name="village_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *
     * @param Integer $id
     */
    public function showVillage(ManagerRegistry $doctrine, $id)
    {
        $villageRepo = $doctrine->getRepository(Village::class);
        $village = $villageRepo->find($id);

        if (!$village) {
            throw $this->createNotFoundException('The village does not exist');
        }

        return $this->render('village/show.html.twig',
            [ 'village' => $village ]
        );

    }

}
