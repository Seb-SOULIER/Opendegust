<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\ApiController;

class HomeController extends AbstractController
{
    public const IMGLOGOPARTENAIRE = [
        "https://www.lesgrappes.com/media/winemaker_tmp/11082/champagneruinart.png",
        "https://1000logos.net/wp-content/uploads/2021/05/Hennessy-logo.png",
        "https://www.lechocolat-alainducasse.com/img/le-chocolat-alain-ducasse-logo-1446054370.jpg",
        "https://www.produit-en-nouvelle-aquitaine.com/wp-content/uploads/2020/04/Logo-entreprise-Laguilhon.jpg",
        "https://1000logos.net/wp-content/uploads/2021/05/Hennessy-logo.png",
        "https://www.lechocolat-alainducasse.com/img/le-chocolat-alain-ducasse-logo-1446054370.jpg",
    ];

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
//        $address = "18 boulevard guillet maillet 17100 Saintes";
//        $api = new ApiController();
//        $localisation = $api->map($address);
        return $this->render('home/index.html.twig', [
////            'localisation' => $localisation,
             'imgLogoPartenaire' => self::IMGLOGOPARTENAIRE
        ]);
    }
}
