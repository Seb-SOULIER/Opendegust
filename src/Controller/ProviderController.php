<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Product;
use App\Entity\Provider;
use App\Form\ProviderPwType;
use App\Form\ProviderType;
use App\Repository\OfferRepository;
use App\Repository\ProductRepository;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/provider")
 */
class ProviderController extends AbstractController
{
    public const STATUS = [
        'UNVERIFIED' => 0,
        'VERIFIED' => 1,
        'DELETED' => 2
    ];

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
            'providers' => $providerRepository->findByStatus()
            ]);
    }

    /**
     * @Route("/show/{id}", name="provider_show")
     */
    public function show(
        ProductRepository $productRepository,
        OfferRepository $offerRepository,
        Provider $provider
    ): Response {
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

            $images = $form->get('files')->getData();
            foreach ($images as $image) {
                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('upload_directory'),
                    $file
                );
                $img = new File();
                $img->setFileName($file);
                $provider->addFile($img);
            }

            $entityManager->persist($provider);
            $entityManager->flush();
            $this->addFlash('success', 'Les informations de votre compte ont été modifiés avec succès !');

            return $this->redirect('/provider/edit');
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
            $provider->setEmail($provider->getPassword());
            $provider->setStatus(self::STATUS['DELETED']);

            $entityManager->flush();
        }

        return $this->redirectToRoute('app_logout');
    }

    /**
     * @Route("/delete/file/{id}", name="provider_delete_file", methods={"GET"})
     */
    public function deleteFile(File $file, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete'.$file->getId(), $data['_token'])) {
            $name = $file->getFileName();
            unlink($this->getParameter('upload_directory').'/'.$name);
            $em = $this->getDoctrine()->getManager();
            $em->remove($file);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Invalid Token'], 400);
        }
    }
}
