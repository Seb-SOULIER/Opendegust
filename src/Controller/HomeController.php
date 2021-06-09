<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\ApiController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $address = "18 boulevard guillet maillet 17100 Saintes";
        $api = new ApiController();
        $localisation = $api->map($address);
        return $this->render('home/index.html.twig', [
            'localisation' => $localisation
        ]);
    }
}
