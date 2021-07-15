<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Calendar;
use App\Entity\Offer;
use App\Entity\OfferVariation;
use App\Form\BookingType;
use App\Form\OfferType;
use App\Form\OfferVariationType;
use App\Repository\CategoryRepository;
use App\Repository\OfferRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/offer", name="offer")
 */
class OfferController extends AbstractController
{
    /**
     * @Route("/", name="_index", methods={"GET"})
     */
    public function index(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/index.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="_new", methods={"GET","POST"})
     */
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $offerVariations = $offer->getOfferVariations();
            foreach ($offerVariations as $offerVariation) {
                $offerVariation->setAvailablePlaces($offerVariation->getCapacity());
            }
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
            'categories' => $categoryRepository->findByCategory(null)
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="_show", methods={"GET"})
     */
    public function show(Request $request, Offer $offer, ProductRepository $productRepository): Response
    {
        $offerVariations = $offer->getOfferVariations();
        $calendarsCount = 0;
        if (null !== $offerVariations) {
            foreach ($offerVariations as $offerVariation) {
                $calendarsCount += count($offerVariation->getCalendars());
            }
        }

        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
            'products' => $productRepository->findByProvider($offer -> getProvider()),
            'offerVariations' => $offerVariations,
            'calendarsCount' => $calendarsCount,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Offer $offer,
        OfferVariation $offerVariation,
        CategoryRepository $categoryRepository
    ): Response {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);


        $formVariation = $this->createForm(OfferVariationType::class, $offerVariation);
        $formVariation->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/edit.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
            'categories' => $categoryRepository->findByCategory(null),
            'formVariation' => $formVariation->createView()
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="_delete", methods={"POST"})
     */
    public function delete(Request $request, Offer $offer): Response
    {
        if ($this->isCsrfTokenValid('delete' . $offer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offer_index');
    }

    /**
     * @Route("/offer-variation-info/{id<\d+>}", name="_variation_info", methods={"GET"})
     */
    public function offerVariationInfo(
        Calendar $calendar,
        Request $request
    ): Response {
        $offerVariation = $calendar->getOfferVariation();
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $offerVariation) {
            $entityManager = $this->getDoctrine()->getManager();

            $adultPlaces = $request->get('adultPlaces');
            $childPlaces = $request->get('childPlaces');

            $booking->setTotalPrice(
                ($adultPlaces * $offerVariation->getPriceVariation()[0])
                + ($childPlaces * $offerVariation->getPriceVariation()[1])
            );
            $booking->setTotalPlaces($adultPlaces + $childPlaces);
            $booking->setPlaces([
                'adultes' => $request->get('adultPlaces'),
                'enfants' => $request->get('childPlaces')]);
            $booking->setCustomer($this->getUser());
            $booking->setCreatedAt(new \DateTime());
            $booking->setOfferVariation($offerVariation);
            $booking->setVat($offerVariation->getCurrentVat());
            $booking->setPriceVariationBook([
                'adultes' => $offerVariation->getPriceVariation()[0],
                'enfants' => $offerVariation->getPriceVariation()[1]
            ]);

            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render('offer/_offer-variation-info.html.twig', [
            'offerVariation' => $offerVariation,
            'form' => $form->createView()
        ]);
    }
}
