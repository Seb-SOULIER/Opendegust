<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Calendar;
use App\Entity\Offer;
use App\Entity\OfferVariation;
use App\Form\BookingType;
use App\Form\CalendarType;
use App\Form\OfferType;
use App\Form\OfferVariationType;
use App\Repository\CalendarRepository;
use App\Repository\CategoryRepository;
use App\Repository\OfferRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $offers = $offerRepository->findByProvider($this->getUser());

        $allOffers = [];
        $alltime = [];

        foreach ($offers as $key => $offer) {
            $offerVariations = $offer->getofferVariations();
            foreach ($offerVariations as $key1 => $offerVariation) {
                $calendars = $offerVariation->getCalendars();
                foreach ($calendars as $calendar) {
                    $allOffers[$key][] = $calendar->getStartAt();
                    $alltime[$key][$key1][] = $calendar->getStartAt();
                }
            }
        }
        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
            'allOffers' => $allOffers,
            'allDuree' => $alltime
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
        $booking = new Booking();
//        $capacity = $offerVariation->getCapacity() - ($adultPlaces + $childPlaces);
        $offerVariations = $offer->getOfferVariations();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        $calendarsCount = 0;
        if (null !== $offerVariations) {
            foreach ($offerVariations as $offerVariation) {
                $calendarsCount += count($offerVariation->getCalendars());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
//            $customer = $this->getUser();

//            $adultPlaces = $request->get('adultPlaces');
//            $childPlaces = $request->get('childPlaces');

//            $booking->setTotalPrice(
//                ($adultPlaces * $offerVariation->getPriceVariation()[0])
//                + ($childPlaces * $offerVariation->getPriceVariation()[1])
//            );
//            $booking->setTotalPlaces($adultPlaces + $childPlaces);
//            $booking->setPlaces(json_encode([
//                'adultes' => $request->get('adultPlaces'),
//                'enfants' => $request->get('childPlaces')]));
//            $booking->setCustomer($customer);
//            $booking->setCreatedAt(new \DateTime());
//            $booking->setOfferVariation($offerVariation);
//            $booking->setVat($offerVariation->getVat());
//            $booking->setPriceVariationBook(json_encode([
//                'adultes' => $offerVariation->getPriceVariation()[0],
//                'enfants' => $offerVariation->getPriceVariation()[1],
//            ]));

            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
            'products' => $productRepository->findByProvider($offer -> getProvider()),
            'offerVariations' => $offerVariations,
            'calendarsCount' => $calendarsCount,
            'form' => $form->createView(),
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
     * @Route("/offer-variation-info", name="_variation_info", methods={"GET"}, priority="1")
     */
    public function offerVariationInfo(
        OfferRepository $offerRepository,
        Request $request,
        CalendarRepository $calendarRepository
    ): Response {
        $offerVariation = [];
        $query = $request->query->get('q');
        if (null !== $query) {
            $calendar = $calendarRepository->findOneBy(['id' => $query]);
            if (null !== $calendar) {
                $offerVariation = $calendar->getOfferVariation();
            }
        }
//        return $this->json($offerVariation, 200, [], ['groups' => ['offer', 'offerVariation']]);
        return $this->render('offer/index.html.twig', [
            'offers' => $offerRepository->findAll(),
            'offerVariation' => $offerVariation
        ]);
    }

    /**
     * @Route("/addform", name="_addform")
     */
    public function addform(Request $request): Response
    {
        $offerVariation = new OfferVariation();

        $form = $this->createForm(OfferVariationType::class, $offerVariation);
        $form->handleRequest($request);

        $calendar = new Calendar();
        $formCalendar = $this->createForm(CalendarType::class, $calendar);
        $formCalendar->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offerVariation);
            $entityManager->flush();

            return $this->redirectToRoute('');
        }

        return $this->render('offer/_form_date.html.twig', [
            'form' => $form->createView(),
            'formCalendar' => $formCalendar->createView(),
        ]);
    }
}
