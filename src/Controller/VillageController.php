<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Village;
use App\Form\VillageType;
use App\Repository\VillageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/village')]
class VillageController extends AbstractController
{


     #[Route("/home", name : "home", methods:"GET")]
    public function indexHome()
    {
        return $this->render('index.html.twig',
            [ 'welcome' => "Have a nice use of the village list" ]
        );
    }


    #[Route('/', name: 'app_village_index', methods: ['GET'])]
    public function index(VillageRepository $villageRepository): Response
    {
        return $this->render('village/index.html.twig', [
            'villages' => $villageRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new/{id}", name="app_village_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VillageRepository $villageRepository, Member $member): Response
    {
        $village = new Village();
        $village->setMember($member);
        $form = $this->createForm(VillageType::class, $village);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $villageRepository->add($village, true);

            return $this->redirectToRoute('app_village_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('village/new.html.twig', [
            'village' => $village,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_village_show', methods: ['GET'])]
    public function show(Village $village): Response
    {
        return $this->render('village/show.html.twig', [
            'village' => $village,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_village_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Village $village, VillageRepository $villageRepository): Response
    {
        $form = $this->createForm(VillageType::class, $village);
        $form->handleRequest($request);
        dump("Following debug is cards before form");

        dump($village->getCards());


        if ($form->isSubmitted() && $form->isValid()) {
            $villageRepository->add($village, true);

            dump("Following debug is cards after form");
            dump($village->getCards());

            // Make sure message will be displayed after redirect
            $this->addFlash('message', 'Village edited');
            // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
            // or to $this->get('session')->getFlashBag()->add();

            return $this->redirectToRoute('app_village_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('village/edit.html.twig', [
            'village' => $village,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_village_delete', methods: ['POST'])]
    public function delete(Request $request, Village $village, VillageRepository $villageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$village->getId(), $request->request->get('_token'))) {
            $villageRepository->remove($village, true);
        }

        return $this->redirectToRoute('app_village_index', [], Response::HTTP_SEE_OTHER);
    }
}
