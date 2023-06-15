<?php

namespace App\Controller;

use App\Repository\OpeningHoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OpeningHoursController extends AbstractController
{
    #[Route('/hours', name: 'app_hours')]
    public function displayHours(OpeningHoursRepository $openingHoursRepository): Response
    {
        $hours = $openingHoursRepository->findAll();
        return $this->render('footer/index.html.twig', [
            'hours' => $hours,
        ]);
    }
}
