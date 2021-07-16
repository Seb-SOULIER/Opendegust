<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\ApiController;
use App\Repository\CategoryRepository;

class HomeController extends AbstractController
{
    public const IMGLOGOPARTENAIRE = [
        "https://www.lesgrappes.com/media/winemaker_tmp/11082/champagneruinart.png",
        "https://1000logos.net/wp-content/uploads/2021/05/Hennessy-logo.png",
        "https://allvectorlogo.com/img/2016/03/moet-chandon-logo.png",
        "https://www.lechocolat-alainducasse.com/img/le-chocolat-alain-ducasse-logo-1446054370.jpg",
        "https://p.ventesprivees-fr.com/pape-clement.png",
    ];


    /**
     * @Route("/", name="home")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
//        $address = "18 boulevard guillet maillet 17100 Saintes";
//        $api = new ApiController();
//        $localisation = $api->map($address);

        return $this->render('home/index.html.twig', [
////            'localisation' => $localisation,
             'imgLogoPartenaire' => self::IMGLOGOPARTENAIRE,
             'gastronomy' => $categoryRepository->findby(['name' => 'Gastronomie']),
             'brassery' => $categoryRepository->findby(['name' => 'Brasserie']),
             'champagne' => $categoryRepository->findby(['name' => 'Vin et Champagne']),
             'cidrery' => $categoryRepository->findby(['name' => 'Cidrerie']),
             'cognac' => $categoryRepository->findby(['name' => 'Cognac et Pineau']),
             'spirituous' => $categoryRepository->findby(['name' => 'Spiritueux']),
             'activities' => $categoryRepository->findby(['name' => 'Activités']),
             'evasion' => $categoryRepository->findby(['name' => 'Evasion']),
             'evenements' => $categoryRepository->findby(['name' => 'Evènements locaux']),
        ]);
    }
}
