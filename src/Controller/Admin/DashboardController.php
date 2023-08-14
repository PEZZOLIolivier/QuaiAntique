<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Dish;
use App\Entity\Menu;
use App\Entity\OpeningHours;
use App\Entity\Photo;
use App\Entity\Reservation;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(ReservationCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('QuaiAntique');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToRoute('Retour au site', 'fa-solid fa-house', 'app_home'),

            MenuItem::section('Horaires & Réservations'),
            MenuItem::linkToCrud('Horaires', 'fa-solid fa-clock', OpeningHours::class),
            MenuItem::linkToCrud('Réservations', 'fa-solid fa-calendar', Reservation::class),

            MenuItem::section('Plâts et menus'),
            MenuItem::linkToCrud('Catégories', 'fa-solid fa-tag', Category::class),
            MenuItem::linkToCrud('Plâts', 'fa-solid fa-fish', Dish::class),
            MenuItem::linkToCrud('Menus', 'fa-solid fa-plate-wheat', Menu::class),

            MenuItem::section('Clients'),
            MenuItem::linkToCrud('Liste client', 'fa-solid fa-user', User::class),
            MenuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', User::class)
                ->setAction('new'),

            MenuItem::section('Photos'),
            MenuItem::linkToCrud('Liste', 'fa fa-picture-o', Photo::class),
            MenuItem::linkToCrud('Ajouter', 'fa fa-plus', Photo::class)
                ->setAction('new'),
        ];
    }
}
