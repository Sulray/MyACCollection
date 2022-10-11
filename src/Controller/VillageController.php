<?php

namespace App\Controller;

use App\Entity\Village;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VillageController extends AbstractController
{
    #[Route('/village', name: 'app_village')]
    public function index(): Response
    {
        return $this->render('village/index.html.twig', [
            'controller_name' => 'VillageController',
        ]);
    }

    /**
     * Lists all village entities
     *
     * @Route("/list", name = "village_list", methods="GET")
     * @Route("/index", name="village_index", methods="GET")
     */
    public function listVillages(ManagerRegistry $doctrine)
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>villages list!</title>
    </head>
    <body>
        <h1>villages list</h1>
        <p>Here are all your villages:</p>
        <ul>';

        $entityManager= $doctrine->getManager();
        $villages = $entityManager->getRepository(Village::class)->findAll();
        foreach($villages as $village) {
            $url = $this->generateUrl(
                'village_show',
                ['id' => $village->getId()]);
            $htmlpage .= '<li>
            <a href='.$url.'>'.$village->getName().'</a></li>';
        }
        $htmlpage .= '</ul>';

        $htmlpage .= '</body></html>';

        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
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
    public function show(ManagerRegistry $doctrine, $id)
    {
        $villageRepo = $doctrine->getRepository(Village::class);
        $village = $villageRepo->find($id);

        if (!$village) {
            throw $this->createNotFoundException('The village does not exist');
        }

        $res = '<p>'.$village->getName()." (".$village->getid().")";

        $res .= '</p><a href="' . $this->generateUrl('village_index') . '">Back</a>';

        return new Response('<html><body>'. $res . '</body></html>');
    }

}