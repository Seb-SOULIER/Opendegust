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
use App\Repository\CategoryRepository;
use App\Repository\OfferRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/offer", name="offer")
 */
class OfferController extends AbstractController
{
    private Security $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
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
            $offer->setProvider($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('offer_edit',[
                'id'=>$offer->getId(),
            ]);
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
    public function show(Offer $offer, ProductRepository $productRepository): Response
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
        CategoryRepository $categoryRepository
    ): Response {

        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        $offerVariation = new OfferVariation();
        $offerVariation->setOffer($offer);
        $formVariation = $this->createForm(OfferVariationType::class, $offerVariation);
        $formVariation->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $form->handleRequest($request);
            return $this->redirectToRoute('offer_index');
        }

        if ($formVariation->isSubmitted() && $formVariation->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $formVariation->handleRequest($request);
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
     * @Route("/offer-variation-info/{id<\d+>}", name="_variation_info")
     */
    public function offerVariationInfo(
        Calendar $calendar,
        Request $request
    ): Response {
        $offerVariation = $calendar->getOfferVariation();
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $adultPlaces = $form->get('adultPlaces')->getData();
            $childPlaces = $form->get('childPlaces')->getData();
            $adultPrice = $form->get('adultPrice')->getData();
            $childPrice = $form->get('childPrice')->getData();
            $booking->setTotalPrice(
                ($adultPlaces * $adultPrice)
                + ($childPlaces * $childPrice)
            );
            $booking->setTotalPlaces($adultPlaces + $childPlaces);
            $booking->setPlaces([
                'adultes' => $adultPlaces,
                'enfants' => $childPlaces
            ]);
            $booking->setCustomer($this->security->getUser());
            $booking->setCreatedAt(new \DateTime());
            $booking->setOfferVariation($offerVariation);
            $booking->setVat($offerVariation->getCurrentVat());
            $booking->setPriceVariationBook([
                'adultes' => $adultPrice,
                'enfants' => $childPrice
            ]);

            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render('offer/_offer-variation-info.html.twig', [
            'calendar' => $calendar,
            'offerVariation' => $offerVariation,
            'form' => $form->createView()
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

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offerVariation);
            $entityManager->flush();

            return $this->redirectToRoute('');
        }

        return $this->render('offer/_bar.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/addcalendar", name="_addcalendar")
     */
    public function addcalendar(Request $request): Response
    {
        $calendar = new Calendar();

        $form2 = $this->createForm(CalendarType::class, $calendar);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($calendar);
            $entityManager->flush();

            return $this->redirectToRoute('');
        }

        return $this->render('offer/_baz.html.twig', [
            'form2' => $form2->createView(),

        ]);
    }
}
