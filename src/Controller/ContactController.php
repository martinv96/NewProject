<?php
// src/Controller/ContactController.php
namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */

     #[Route('/profile', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer une nouvelle instance de Contact
        $contact = new Contact();

        // Créer le formulaire
        $form = $this->createForm(ContactType::class, $contact);

        // Traiter le formulaire lors de la soumission
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les données dans la base de données
            $entityManager->persist($contact);
            $entityManager->flush();

            // Optionnel : Ajouter un message flash
            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            // Rediriger vers la même page ou une autre page
            return $this->redirectToRoute('profile');
        }

        // Renvoyer le formulaire à la vue
        return $this->render('pages/profile/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}