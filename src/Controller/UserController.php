<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user_index')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash le mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            // Enregistre l'utilisateur dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirige après l'inscription
            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/user/index.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
