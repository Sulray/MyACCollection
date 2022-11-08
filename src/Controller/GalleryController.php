<?php

namespace App\Controller;

use App\Entity\Gallery;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{

    #[Route('/personality', name: 'app_gallery')]
    public function index(): Response
    {
        return $this->render('gallery/index.html.twig', [
            'controller_name' => 'GalleryController',
        ]);
    }

    /**
     * Lists all gallery entities.
     *
     * @Route("/gallery-list", name = "gallery_list", methods="GET")
     * @Route("/gallery-index", name = "gallery_index", methods="GET")

     */
    public function listGalleryy(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $galleries = $entityManager->getRepository(Gallery::class)->findAll();

        dump($galleries);

        return $this->render('galleryy/index.html.twig',
            [ 'galleries' => $galleries ]
        );
    }

    /**
     * Show a gallery
     *
     * @Route("/gallery/{id}", name="gallery_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *
     * @param Integer $id
     */
    public function showGallery(ManagerRegistry $doctrine, $id)
    {
        $galleryRepo = $doctrine->getRepository(Gallery::class);
        $gallery = $galleryRepo->find($id);

        if (!$gallery) {
            throw $this->createNotFoundException('The gallery does not exist');
        }

        return $this->render('gallery/show.html.twig',
            [ 'gallery' => $gallery ]
        );

    }

}
