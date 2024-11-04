<?php

namespace App\Controller;

use App\Document\Restaurant;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RestaurantController extends AbstractController {

    #[Route('/restaurant', name: 'app_restaurant')]

    function index(DocumentManager $dm): Response {
        return $this->render('pages/restaurant/index.html.twig');
    }


    #[Route('/restaurant/create', name: 'app_restaurant_create', methods: ['POST'])]

    function createRestaurant(Request $requete, DocumentManager $dm) {
        $nomRestaurant = $requete->request->get('name');
        
        if (isset($nomRestaurant)) {
            $restaurant = new Restaurant();
            $restaurant->setName($nomRestaurant);
            $dm->persist($restaurant);
            $dm->flush();
        }
        return $this->redirectToRoute('app_restaurant');

    }
}