<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Dish;
use App\Entity\Menu;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardAndMenusController extends AbstractController
{
    #[Route('/cardandmenus', name: 'app_card_and_menus')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repositoryDish = $doctrine ->getRepository(Dish::class);
        $resultDish = $repositoryDish->getAllActiveDish();
        $resultCategory = $doctrine ->getRepository(Category::class)->findAllCategory();
        $repositoryMenu = $doctrine->getRepository(Menu::class);
        $resultMenu = $repositoryMenu->getAllActiveMenu();

        return $this->render('card_and_menus/index.html.twig', [
            'controller_name'=> 'CardAndMenusController',
            'dishes_dish' => $resultDish,
            'dishes_menu' => $resultMenu,
            'categories' => $resultCategory,
        ]);
    }
}
