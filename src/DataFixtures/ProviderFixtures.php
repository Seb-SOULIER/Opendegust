<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Description;
use App\Entity\File;
use App\Entity\Provider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProviderFixtures extends Fixture
{
    private const PROVIDER_NUMBER = 50;
    private const SOCIAL_REASONS = ['SARL', 'EURL', 'SAS', 'SASU', 'SA', 'EI'];
    private const OTHER_SITE = 3;
    private const KNOW_US = ['Publicité', 'Internet', 'Bouche à oreille', 'Autre'];

    private array $opening = [
        'day' => ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
        'start' => 7,
        'lunch_start' => 12,
        'lunch_end' => 13,
        'end' => 17
    ];

    private $passwordEncoder;
    private array $otherSite = [];
    protected $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create('fr-FR');

        for ($i = 1; $i <= self::OTHER_SITE; $i++) {
            $this->otherSite[] = $this->faker->domainName;
        }

        for ($i = 1; $i <= self::PROVIDER_NUMBER; $i++) {
            $provider = new Provider();
            $contact = new Contact();
            $description = new Description();

            $provider->setEmail($this->faker->email);
            $provider->setRoles(['ROLE_PROVIDER']);
            $provider->setPassword($this->passwordEncoder->encodePassword(
                $provider,
                'toto'
            ));
            $provider->setRegistrationAt($this->faker->dateTime);
            $provider->setCivility($this->faker->numberBetween(1, 3));
            $provider->setFirstname($this->faker->firstName);
            $provider->setLastname($this->faker->lastName);
            $provider->setCompany($this->faker->company);
            $provider->setSocialReason(array_rand(array_flip(self::SOCIAL_REASONS)));
            $provider->setSiret($this->faker->numberBetween(11111, 64000));
            $provider->setVatNumber($this->faker->randomFloat(2, 10, 25));
            $provider->setOpening(json_encode($this->opening));
            $provider->setMonthlyFrequentation($this->faker->randomDigit());
            $provider->setOtherSite(json_encode($this->otherSite));
            $provider->setKnowUs(array_rand(array_flip(self::KNOW_US)));
            $provider->setContact($contact);
            $provider->setDescription($description);

            $contact->setAddress($this->faker->address);
            $contact->setZipcode($this->faker->postcode);
            $contact->setCity($this->faker->city);
            $contact->setLongitude($this->faker->longitude);
            $contact->setLatitude($this->faker->latitude);
            $contact->setPhone($this->faker->phoneNumber);
            $contact->setPhone2($this->faker->phoneNumber);
            $contact->setWebsite($this->faker->domainName);
            $manager->persist($contact);
            $provider->setContact($contact);

            $description->setShortDescription($this->faker->text(100));
            $description->setLongDescription($this->faker->text(300));
            $manager->persist($description);
            $provider->setDescription($description);

//            $file = new File();
//            $file->setFileName($i . ".jpeg");
//            $file->setFilePath($i);
//            $manager->persist($file);
//            $provider->addFile($file);

            $this->addReference('provider_' . $i, $provider);
            $this->addReference('description_' . $i, $description);
            $this->addReference('contact' . $i, $contact);

            $manager->persist($provider);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProviderFixtures::class,
        ];
    }
}
