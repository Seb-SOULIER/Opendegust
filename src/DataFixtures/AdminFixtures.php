<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Description;
use App\Entity\Provider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        //admin test

        $provider = new Provider();
        $contact = new Contact();
        $description = new Description();

        $provider->setEmail('admin@test.fr');
        $provider->setRoles(['ROLE_ADMIN']);
        $provider->setPassword($this->passwordEncoder->encodePassword(
            $provider,
            'admin'
        ));
        $provider->setRegistrationAt(new \DateTime());
        $provider->setCivility(2);
        $provider->setPicture(null);
        $provider->setFirstname('Marielle');
        $provider->setLastname('NIANGUI');
        $provider->setCompany('openDegust');
        $provider->setSocialReason(null);
        $provider->setSiret(null);
        $provider->setVatNumber(null);
        $provider->setOpening(null);
        $provider->setMonthlyFrequentation(null);
        $provider->setOtherSite(null);
        $provider->setKnowUs(null);
        $provider->setContact($contact);
        $provider->setDescription($description);

//        $contact->setAddress(null);
//        $contact->setZipcode(null);
//        $contact->setCity(null);
//        $contact->setLongitude(null);
//        $contact->setLatitude(null);
//        $contact->setPhone(null);
//        $contact->setPhone2(null);
//        $contact->setWebsite(null);
        $manager->persist($contact);
        $provider->setContact($contact);

        $description->setShortDescription(null);
        $description->setLongDescription(null);
        $manager->persist($description);
        $provider->setDescription($description);

        $manager->persist($provider);

        $manager->flush();

        //provider test

        $provider = new Provider();
        $contact = new Contact();
        $description = new Description();

        $provider->setEmail('provider@test.fr');
        $provider->setRoles(['ROLE_PROVIDER']);
        $provider->setPassword($this->passwordEncoder->encodePassword(
            $provider,
            'provider'
        ));
        $provider->setRegistrationAt(new \DateTime());
        $provider->setCivility(2);
        $provider->setPicture(null);
        $provider->setFirstname('Marielle');
        $provider->setLastname('NIANGUI');
        $provider->setCompany('openDegust');
        $provider->setSocialReason(null);
        $provider->setSiret(null);
        $provider->setVatNumber(null);
        $provider->setOpening(null);
        $provider->setMonthlyFrequentation(null);
        $provider->setOtherSite(null);
        $provider->setKnowUs(null);
        $provider->setContact($contact);
        $provider->setDescription($description);

//        $contact->setAddress(null);
//        $contact->setZipcode(null);
//        $contact->setCity(null);
//        $contact->setLongitude(null);
//        $contact->setLatitude(null);
//        $contact->setPhone(null);
//        $contact->setPhone2(null);
//        $contact->setWebsite(null);
        $manager->persist($contact);
        $provider->setContact($contact);

        $description->setShortDescription(null);
        $description->setLongDescription(null);
        $manager->persist($description);
        $provider->setDescription($description);

        $manager->persist($provider);

        $manager->flush();
    }
}
