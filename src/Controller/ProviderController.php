<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Provider;
use App\Form\ProviderPwType;
use App\Form\ProviderType;
use App\Repository\OfferRepository;
use App\Repository\ProductRepository;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/provider")
 */
class ProviderController extends AbstractController
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

     /**
     * @Route("/", name="provider_index")
     */
    public function index(ProviderRepository $providerRepository): Response
    {
        return $this->render('provider/index.html.twig', [
            'providers' => $providerRepository->findAll()
        ]);
    }

    /**
     * @Route("/show", name="provider_show", methods={"GET"})
     */
    public function show(
        ProductRepository $productRepository,
        OfferRepository $offerRepository
    ): Response {
        $provider = $this->getUser();
        return $this->render('provider/show.html.twig', [
            'provider' => $provider,
            'products' => $productRepository->findBy(['provider' => $provider->getId()]),
            'offers' => $offerRepository->findBy(['provider' => $provider->getId()])
        ]);
    }

    /**
     * @Route("/edit", name="provider_edit", methods={"GET","POST"})
     */
    public function edit(Request $request): Response
    {
        $provider = $this->getUser();
        $formPw = $this->createForm(ProviderPwType::class, $provider);
        $form = $this->createForm(ProviderType::class, $provider);
        $formPw->handleRequest($request);
        $form->handleRequest($request);
//        $serializer = $this->container->get('serializer');
//        $otherSite = $serializer->serialize($form->get('otherSite')->getData(), 'json');
//        $provider->setOtherSite($otherSite);

        if ($formPw->isSubmitted() && $formPw->isValid()) {
            $provider->setPassword(
                $this->passwordEncoder->encodePassword(
                    $provider,
                    $formPw->get('password')->getData()
                )
            );
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Mot de passe modifié avec succès !');
            return $this->redirect('/provider/' . $provider->getId() . '/edit');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($provider);
            $entityManager->flush();
            $this->addFlash('success', 'Les informations de votre compte ont été modifiés avec succès !');

            return $this->redirect('/provider/' . $provider->getId() . '/edit');
        }

        return $this->render('provider/edit.html.twig', [
            'provider' => $provider,
            'form' => $form->createView(),
            'formPw' => $formPw->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="provider_delete", methods={"POST"})
     */
    public function delete(Request $request, Provider $provider): Response
    {
        if ($this->isCsrfTokenValid('delete' . $provider->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($provider);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}
