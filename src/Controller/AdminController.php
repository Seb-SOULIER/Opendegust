<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Entity\Offer;
use App\Entity\Provider;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->render('admin/index.html.twig',[
            'providers' => $providerRepository->findAll()
        ]);
    }

    /**
     * @Route("/validate/{id}", name="_validate", methods={"GET"})
     */
    public function validateProvider(Provider $provider): response
    {
        if ($provider->getStatus() === 1) {
            $provider->setStatus(0);
        } else {
            $provider->setStatus(1);
        }
        $this->getDoctrine()->getManager()->flush();
        return $this->json([]);
    }
}
