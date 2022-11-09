<?php

namespace App\Controller;

use App\Entity\Card;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/card')]
class CardController extends AbstractController
{

    /**
     * Lists all card entities
     *
     * @Route("/list", name = "card_list", methods="GET")
     * @Route("/", name="card_index", methods="GET")
     */
    public function index(ManagerRegistry $doctrine)
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
     * @Route("/{id}", name="card_show", requirements={"id"="\d+"})
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

        return $this->render('card/show.html.twig',
            [ 'card' => $card ]
        );
    }

}
