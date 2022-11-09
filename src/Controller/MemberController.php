<?php

namespace App\Controller;

use App\Entity\Member;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/member')]
class MemberController extends AbstractController
{
    /**
     * Lists all member entities
     *
     * @Route("/list", name = "member_list", methods="GET")
     * @Route("/", name="member_index", methods="GET")
     */
    public function index(ManagerRegistry $doctrine)
    {
        $entityManager= $doctrine->getManager();
        $members = $entityManager->getRepository(Member::class)->findAll();

        dump($members);

        return $this->render('member/index.html.twig',
            [ 'members' => $members ]
        );
    }

    /**
     * Show a member
     *
     * @Route("/{id}", name="member_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *
     * @param Integer $id
     */
    public function show(ManagerRegistry $doctrine, $id)
    {
        $memberRepo = $doctrine->getRepository(Member::class);
        $member = $memberRepo->find($id);

        if (!$member) {
            throw $this->createNotFoundException('The member does not exist');
        }

        return $this->render('member/show.html.twig',
            [ 'member' => $member ]
        );
    }

}
