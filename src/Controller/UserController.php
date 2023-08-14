<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        if ($user == null) {
            $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(UserType::class, $user);

        if ($request->getMethod() == "POST") {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $doctrine->getManager()->persist($user);
                $doctrine->getManager()->flush();
            }
        }

        return $this->render('account/index.html.twig', [
            'userForm' => $form,
        ]);
    }
}