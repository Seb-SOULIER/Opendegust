<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CustomerFixtures extends Fixture
{
    private const CUSTOMER_NUMBER = 50;
    private const KNOW_US = ['Publicité', 'Internet', 'Bouche à oreille', 'Autre'];

    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for ($i = 1; $i <= self::CUSTOMER_NUMBER; $i++) {
            $customer = new Customer();
            $categories = CategoryFixtures::CATEGORY;

            $customer->setEmail($this->faker->email);
            $customer->setRoles('ROLE_CUSTOMER');
            $customer->setPassword('tata');
            $customer->setRegistrationAt($this->faker->dateTime);
            $customer->setCivility($this->faker->numberBetween(1, 3));
            $customer->setFirstname($this->faker->firstName);
            $customer->setLastname($this->faker->lastName);

            $customer->setBirthdate($this->faker->dateTime);
            $customer->setKnowUs(json_encode(self::KNOW_US));
            $customer->setGtc18($this->faker->boolean());
            $customer->setFavory(json_encode(array_rand($categories, rand(1, 10))));

            $contact = new Contact();
            $contact->setAddress($this->faker->sentence(3));
            $contact->setZipcode($this->faker->postcode);
            $contact->setCity($this->faker->city);
            $contact->setLongitude($this->faker->longitude);
            $contact->setLatitude($this->faker->latitude);
            $contact->setPhone($this->faker->phoneNumber);
            $contact->setPhone2($this->faker->phoneNumber);
            $contact->setWebsite($this->faker->domainName);
            $manager->persist($contact);
            $customer->setContact($contact);

            $this->addReference('customer_' . $i, $customer);
            $this->addReference('contact_' . $i, $contact);

            $manager->persist($customer);
        }
        $manager->flush();
    }
}