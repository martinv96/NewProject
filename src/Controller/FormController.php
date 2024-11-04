<?php

namespace App\Controller;

use App\Entity\Form;
use App\Form\FormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    #[Route('/form', name: 'form_index')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $formEntity = new Form();
        $form = $this->createForm(FormType::class, $formEntity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistre la date actuelle si elle n'est pas spécifiée
            if ($formEntity->getDate() === null) {
                $formEntity->setDate(new \DateTimeImmutable());
            }

            // Associe le formulaire à l'utilisateur connecté
            $formEntity->setUser($this->getUser());

            // Enregistre l'entité dans la base de données
            $entityManager->persist($formEntity);
            $entityManager->flush();

            // Redirige vers une page de succès ou une autre page si nécessaire
            return $this->redirectToRoute('form_success');
        }

        return $this->render('pages/form/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/form/success', name: 'form_success')]
    public function success(): Response
    {
        return $this->render('pages/form/success.html.twig');
    }
}
