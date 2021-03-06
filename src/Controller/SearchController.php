<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Repository\CategoryRepository;
use App\Repository\OfferRepository;
use App\Service\Api;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/{id}/favory", name="favory", methods={"GET"})
     */

    public function addToFavorite(Offer $offer, EntityManagerInterface $manager): Response
    {
        if ($this->getUser()->isInFavory($offer)) {
            $this->getUser()->removeFavory($offer);
        } else {
            $this->getUser()->addFavory($offer);
        }
        $manager->flush();

        return $this->json([
            'isInFavory' => $this->getUser()->isInFavory($offer)
        ]);
    }

    /**
     * @Route("/", name="localization")
     */
    public function search(
        Request $request,
        Api $api,
        CategoryRepository $categoryRepository,
        OfferRepository $offerRepository
        ): Response {

        $query = $request->query->get('q');
        $zoom = 11;

        if (!$query) {
            $localization = [0 => ['lat' => 46.16, 'lon' => 3.19619]];
            $zoom = 5;
        } else {
            $url = "https://nominatim.openstreetmap.org/search?q="
                . $query . "&format=json&addressdetails=1&limit=1";
            $localization = $api->getResponse($url);
        }

        $offers = $offerRepository->findFilter($request, $localization ?? [0 => ['lat' => 46.16, 'lon' => 3.19619]]);

        return $this->render('search/index.html.twig', [
            'localization' => $localization ?? [],
            'offers' => $offers,
            'categories' => $categoryRepository->findBy(['category' => null]),
            'zoom' => $zoom
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
