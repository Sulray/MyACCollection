<?php

namespace App\Controller;

use App\Entity\Card;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    #[Route('/card', name: 'app_card')]
    public function index(): Response
    {
        return $this->render('card/index.html.twig', [
            'controller_name' => 'CardController',
        ]);
    }

    /**
     * Lists all card entities
     *
     * @Route("/card_list", name = "card_list", methods="GET")
     * @Route("/card_index", name="card_index", methods="GET")
     */
    public function listCards(ManagerRegistry $doctrine)
    {
        $entityManager= $doctrine->getManager();
        $cards = $entityManager->getRepository(Card::class)->findAll();

        dump($cards);

        return $this->render('card/index.html.twig',
            [ 'cards' => $cards ]
        );
    }

    /**
     * Show a card
     *
     * @Route("/card/{id}", name="card_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *
     * @param Integer $id
     */
    public function show(ManagerRegistry $doctrine, $id)
    {
        $cardRepo = $doctrine->getRepository(Card::class);
        $card = $cardRepo->find($id);

        if (!$card) {
            throw $this->createNotFoundException('The card does not exist');
        }

        $res = '<p>'.$card->getName()." (".$card->getid().")";

        $res .= '</p><a href="' . $this->generateUrl('card_index') . '">Back</a>';

        return new Response('<html><body>'. $res . '</body></html>');
    }

}
