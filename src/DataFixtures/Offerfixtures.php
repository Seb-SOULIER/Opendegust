<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Description;
use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Offerfixtures extends Fixture implements DependentFixtureInterface
{
    private const OFFER_NUMBER = 4;
    private const NBR_PROVIDER = 50;
    protected $faker;
    public const LANGUAGE = ['Français','Anglais','Espagnol','Chinois','Japonais','Russe','Portugais'];

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for ($a = 1; $a <= self::NBR_PROVIDER; $a++) {
            for ($i = 1; $i <= self::OFFER_NUMBER; $i++) {
                $offer = new Offer();
                $offer->setName($this->faker->sentence(3));
                $offer->setPicture($this->faker->imageUrl(640, 480, 'food', true));
                $offer->setDomainName($this->faker->sentence(3));
                $offer->setLanguage(json_encode(self::LANGUAGE));
                $offer->setProvider($this->getReference('provider_' . $a));

                $description = new Description();
                $description->setShortDescription($this->faker->sentence(15));
                $description->setLongDescription($this->faker->sentence(50));
                $manager->persist($description);
                $offer->setDescription($description);

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
                $offer->setContact($contact);

                $manager->persist($offer);
            }
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            ProviderFixtures::class,
        ];
    }
}
