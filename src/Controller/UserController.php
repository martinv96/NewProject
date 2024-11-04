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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user_index')]
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

    #[Route('/connexion', name: 'connexion')]

    public function connexion(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupère l'erreur de connexion, s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier email entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        if (!$error) {
            $this->addFlash('success', 'Connexion réussie');
        }


        return $this->render('pages/user/connexion.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);

    }

    #[Route('/logout', name: 'deconnexion')]

    public function logout() {
        
    }
    

}
