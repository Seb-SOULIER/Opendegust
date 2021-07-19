<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="booking")
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        $books = $bookingRepository->findBy(['customer' => $this->getUser()]);
        return $this->render('booking/index.html.twig', [
            'books' => $books
        ]);
    }
}
