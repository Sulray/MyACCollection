<?php

namespace App\Controller;

use App\Entity\Member;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    #[Route('/member', name: 'app_member')]
    public function index(): Response
    {
        return $this->render('member/index.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }

    /**
     * Lists all member entities
     *
     * @Route("/member_list", name = "member_list", methods="GET")
     * @Route("/member_index", name="member_index", methods="GET")
     */
    public function listMembers(ManagerRegistry $doctrine)
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
     * @Route("/member/{id}", name="member_show", requirements={"id"="\d+"})
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

        $res = '<p>'.$member->getName()." (".$member->getid().")";

        $res .= '</p><a href="' . $this->generateUrl('member_index') . '">Back</a>';

        return new Response('<html><body>'. $res . '</body></html>');
    }

}
