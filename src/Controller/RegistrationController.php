<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Customer;
use App\Entity\Provider;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use DateTime;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(EmailVerifier $emailVerifier, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->emailVerifier = $emailVerifier;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/register-customer", name="app_register_customer")
     */
    public function registerCustomer(Request $request): Response
    {
        $user = new Customer();
        $user->setRoles(['ROLE_CUSTOMER']);
        return $this->register($request, $user);
    }

    /**
     * @Route("/register-provider", name="app_register_provider")
     */
    public function registerProvider(Request $request): Response
    {
        $user = new Provider();
        $user->setRoles(['ROLE_PROVIDER']);
        return $this->register($request, $user);
    }


    public function register(Request $request, User $user): Response
    {
        $contact = new Contact();
        $user->setContact($contact);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRegistrationAt(new Datetime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('mailer@your-domain.com', 'Mailer'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        // $this->addFlash('success', 'Adresse email validée.');

        return $this->redirectToRoute('home');
    }
}
