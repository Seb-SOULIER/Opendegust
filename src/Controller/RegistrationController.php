<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Customer;
use App\Entity\Description;
use App\Entity\Provider;
use App\Form\RegistrationFormType;
use App\Security\AppUserAuthenticator;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
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
     * @Route("/register", name="register")
     */
    public function index(): Response
    {
        return $this->render('registration/register.html.twig');
    }

    /**
     * @Route("/register-customer", name="app_register_customer", methods={"POST", "GET"})
     */
    public function registerCustomer(
        Request $request,
        GuardAuthenticatorHandler $guardHandler,
        AppUserAuthenticator $authenticator
    ): ?Response {
        $user = new Customer();
        $user->setRoles(['ROLE_CUSTOMER']);
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
                    ->from($this->getParameter('mailer_from'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Identifiants invalides');
            return $this->redirectToRoute('register');
        }
        return $this->render('registration/_register_customer.html.twig', [
            'registrationForm' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/register-provider", name="app_register_provider", methods={"POST", "GET"})
     */
    public function registerProvider(
        Request $request,
        GuardAuthenticatorHandler $guardHandler,
        AppUserAuthenticator $authenticator
    ): ?Response {
        $user = new Provider();
        $user->setRoles(['ROLE_PROVIDER']);
        $contact = new Contact();
        $description = new Description();
        $user->setContact($contact);
        $user->setDescription($description);
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
                    ->from($this->getParameter('mailer_from'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Identifiants invalides');
            return $this->redirectToRoute('register');
        }
        return $this->render('registration/_register_provider.html.twig', [
            'registrationForm' => $form->createView(),
            'user' => $user,
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
