<?php

namespace App\Controller\Admin;

use App\Entity\Band;
use App\Entity\Live;
use App\Entity\Song;
use App\Entity\User;
use App\Entity\Album;
use App\Entity\Order;
use App\Entity\Stock;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Message;
use App\Entity\Category;
use App\Entity\Plateform;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Basaalt : back-office')
            ->setLocales(['fr', 'en']);
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setEntityLabelInSingular('...')
            ->setEntityLabelInPlural('...')
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(30)
            // ->setPageTitle()
            ->setDateTimeFormat('dd/MM/yyyy à HH:mm')
            ->setTimezone('Europe/Paris')
            ->setDefaultSort(['createdAt' => 'DESC'])
            // ->setFormOptions()
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        // -------------------------------------------------------------
        yield MenuItem::section('Gestion du groupe');
        yield MenuItem::linkToCrud('Le groupe', 'fa fa-people-group', Band::class);
        yield MenuItem::linkToCrud('Les concerts', 'fa fa-calendar-days', Live::class);
        yield MenuItem::linkToCrud('Streaming', 'fa-brands fa-spotify', Plateform::class);
        yield MenuItem::linkToCrud('Albums', 'fa fa-record-vinyl', Album::class);
        yield MenuItem::linkToCrud('Titres', 'fa fa-music', Song::class);

        // -------------------------------------------------------------
        yield MenuItem::section('E-commerce');
        yield MenuItem::linkToCrud('Categories', 'fa fa-list', Category::class);
        yield MenuItem::linkToCrud('Articles', 'fa fa-shirt', Article::class);
        yield MenuItem::linkToCrud('Stocks', 'fa fa-shirt', Stock::class);
        yield MenuItem::linkToCrud('Commandes', 'fa fa-shirt', Order::class);
        // -------------------------------------------------------------
        yield MenuItem::section('Messages & Commentaires');
        yield MenuItem::linkToCrud('Messages', 'fa fa-message', Message::class);
        yield MenuItem::linkToCrud('Commentaires', 'fa fa-comment', Comment::class);
        // -------------------------------------------------------------
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
    }
}
