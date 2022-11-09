<?php

namespace App\Controller;

use App\Entity\Village;
use App\Form\VillageType;
use App\Repository\VillageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class VillageController extends AbstractController
{
    /**
     * @Route("/", name = "home", methods="GET")
     */
    public function indexHome()
    {
        return $this->render('index.html.twig',
            [ 'welcome' => "Have a nice use of the village list" ]
        );
    }

    /**
     * Lists all village entities.
     *
     * @Route("/village/list", name = "village_list", methods="GET")
     * @Route("/village", name = "village_index", methods="GET")

     */
    public function index(ManagerRegistry $doctrine): Response
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
    public function show(ManagerRegistry $doctrine, $id)
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

    #[Route('/village/new', name: 'village_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VillageRepository $galleryRepository): Response
    {
        $village = new Village();
        $form = $this->createForm(VillageType::class, $village);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $galleryRepository->add($village, true);

            return $this->redirectToRoute('village_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('village/new.html.twig', [
            'village' => $village,
            'form' => $form,
        ]);
    }


    #[Route('/village/{id}/edit', name: 'village_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Village $village, VillageRepository $villageRepository): Response
    {
        $form = $this->createForm(VillageType::class, $village);
        $form->handleRequest($request);

        dump($form);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form);

            $villageRepository->add($village, true);

            return $this->redirectToRoute('village_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('village/edit.html.twig', [
            'village' => $village,
            'form' => $form,
        ]);
    }

    #[Route('/village/{id}', name: 'village_delete', methods: ['POST'])]
    public function delete(Request $request, Village $village, VillageRepository $villageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$village->getId(), $request->request->get('_token'))) {
            $villageRepository->remove($village, true);
        }

        return $this->redirectToRoute('village_index', [], Response::HTTP_SEE_OTHER);
    }



}
