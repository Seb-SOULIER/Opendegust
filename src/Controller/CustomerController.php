<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Offer;
use App\Form\CustomerPwType;
use App\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/customer")
 */
class CustomerController extends AbstractController
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/{id}", name="customer_show", methods={"GET"})
     */
    public function show(Customer $customer): Response
    {
        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="customer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Customer $customer): Response
    {
        $formPw = $this->createForm(CustomerPwType::class, $customer);
        $form = $this->createForm(CustomerType::class, $customer);
        $formPw->handleRequest($request);
        $form->handleRequest($request);

        if ($formPw->isSubmitted() && $formPw->isValid()) {
            $customer->setPassword(
                $this->passwordEncoder->encodePassword(
                    $customer,
                    $formPw->get('password')->getData()
                )
            );
            $this->addFlash('success', 'Mot de passe modifié avec succès !');
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect('/customer/' . $customer->getId() . '/edit');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Les informations de votre compte ont été modifiés avec succès !');
            return $this->redirect('/customer/' . $customer->getId() . '/edit');
        }

        return $this->render('customer/edit.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
            'formPw' => $formPw->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="customer_delete", methods={"POST"})
     */
    public function delete(Request $request, Customer $customer): Response
    {
        if ($this->isCsrfTokenValid('delete' . $customer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $customer->setEmail(null);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/{id}/favorite", name="customer_favorite")
     */
    public function displayFavoriteIndex(Offer $offer, Customer $customer): Response
    {
         return $this->render(
             'customer/favindex.html.twig',
             [
                 'offer' => $offer,
                 'customer' => $customer
             ]
         );
    }
}
