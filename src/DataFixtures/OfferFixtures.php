<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Description;
use App\Entity\Offer;
use App\Entity\OfferVariation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OfferFixtures extends Fixture implements DependentFixtureInterface
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
                $offer->setName($this->faker->sentence(2));
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
                $contact->setZipcode($this->faker->postcode);
                $contact->setAddress($this->faker->sentence(3));
                $contact->setCity($this->faker->city);
                $contact->setLongitude($this->faker->longitude);
                $contact->setLatitude($this->faker->latitude);
                $contact->setPhone($this->faker->phoneNumber);
                $contact->setPhone2($this->faker->phoneNumber);
                $contact->setWebsite($this->faker->domainName);
                $manager->persist($contact);
                $offer->setContact($contact);

                for ($i = 1; $i <= rand(1, 5); $i++) {
                    $offerVariation = new OfferVariation();
                    $offerVariation->setPriceVariation(json_encode([
                        'adultes' => rand(1, 50),
                        'enfants' => rand(1, 30)]));
                    $offerVariation->setCapacity(rand(1, 50));
                    $offerVariation->setDuration((new \DateTime)->setTime(rand(0, 10), rand(0, 59)));
                    $offerVariation->setPrice(rand(1, 50));
                    $offerVariation->setCurrentVat(rand(5, 25));
                    $offerVariation->setOffer($offer);
                    $manager->persist($offerVariation);
                }

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
