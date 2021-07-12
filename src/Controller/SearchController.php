<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Repository\CategoryRepository;
use App\Repository\ContactRepository;
use App\Service\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/search", name="search_")
*/
class SearchController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $offers = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->findAll();
        return $this->render('search/index.html.twig', [
            'offers' => $offers
        ]);
    }

    /**
     * @Route("/coordinate", name="coordinate")
     */
    public function coordinate(Request $request, ContactRepository $contactRepository): Response
    {
        $coordinate = $contactRepository->findAll();
        return $this->json($coordinate ?? []);
            //'{\"adultes\":3,\"enfants\":4}';
        //$this->json($coordinate ?? []);
    }


    /**
     * @Route("/localization", name="localization")
     */
    public function search(Request $request, Api $api, CategoryRepository $categoryRepository): Response
    {

        $query = $request->query->get('q');

        if (null !== $query) {
            $url = "https://nominatim.openstreetmap.org/search?q="
            . $query . "&format=json&addressdetails=1&limit=1";
            $localization = $api->getResponse($url);
        }

        $offers = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->findAll();

        return $this->render('search/index.html.twig', [
            'localization' => $localization ?? [],
            'offers' => $offers,
            'categories' => $categoryRepository->findBy(['category' => null])
        ]);
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     * @return Response
     */
    public function autocomplete(Request $request, Api $api): Response
    {
        $query = $request->query->get('q');

        if (null !== $query) {
            $url = "https://api-adresse.data.gouv.fr/search/?q=" . $query . "&limit=5&type=municipality";
            $localization = $api->getResponse($url);
        }

        return $this->json($localization ?? []);
    }
}
