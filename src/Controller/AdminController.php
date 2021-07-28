<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="_index", methods={"GET"})
     */
    public function index(ProviderRepository $providerRepository): Response
    {
        $provider = $providerRepository->findAll();
        return $this->render('admin/index.html.twig', ['provider' => $provider]);
    }
}
