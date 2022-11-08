<?php

namespace App\Controller\Admin;

use App\Entity\Card;
use App\Entity\Gallery;
use App\Entity\Member;
use App\Entity\Personality;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Village;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(VillageCrudController::class)->generateUrl();
        return $this->redirect($url);
        // you can also redirect to different pages depending on the current user

        //if ('jane' === $this->getUser()->getUsername()) {
        //    return $this->redirect('...');
        //}

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //return $this->render('some/path/my-dashboard.html.twig');
        }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Myaccollection');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Village', 'fas fa-list', Village::class);
        yield MenuItem::linkToCrud('Card', 'fas fa-list', Card::class);
        yield MenuItem::linkToCrud('Member', 'fas fa-list', Member::class);
        yield MenuItem::linkToCrud('Gallery', 'fas fa-list', Gallery::class);
        yield MenuItem::linkToCrud('Personality', 'fas fa-list', Personality::class);

    }
}
