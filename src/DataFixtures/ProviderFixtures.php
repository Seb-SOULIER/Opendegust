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
    private const PROVIDER_NUMBER = 20;
    private const SOCIAL_REASONS = ['SARL', 'EURL', 'SAS', 'SASU', 'SA', 'EI'];
    private const OTHER_SITE = 3;
    private const KNOW_US = ['Publicité', 'Internet', 'Bouche à oreille', 'Autre'];

    private const PICTURE = [

        '1' => 'https://thumbs.dreamstime.com/b/personne-intelligente-en-lunettes-
        un-homme-tenue-officielle-est-debout-sur-fond-blanc-dans-le-studio-165962936.jpg',
        '2' => 'https://media.istockphoto.com/photos/happy-man-winking-and-pointing-
        at-you-picture-id899284784',
        '3' => 'https://media.istockphoto.com/photos/portrait-of-caucasian-young-woman-with-blank-expression-picture-id1126633358?s=612x612',
        '4' => 'https://thumbs.dreamstime.com/b/jeune-homme-heureux-93838547.jpg',
        '5' => 'https://media.istockphoto.com/photos/real-caucasian-adult-woman-with-blank-expression-picture-id1081878264?s=612x612',
        '6' => 'https://previews.123rf.com/images/rido/rido1407/rido140700015/29862726-portrait-de-jeune-
        homme-heureux-afficher-thumb-up-isol%C3%A9-sur-fond-blanc.jpg',
        '7' => 'https://previews.123rf.com/images/goodluz/goodluz1505/goodluz150500041/39464767-portrait-
        de-sourire-homme-d-%C3%A2ge-m%C3%BBr-debout-dans-le-couloir.jpg',
        '8' => 'https://wallpapercave.com/wp/CIcfPDI.jpg',
        '9' => 'https://www.atelierphoto.ch/images/prestations/photopasseport.jpg',
        '10' => 'https://st2.depositphotos.com/2783505/11506/i/950/depositphotos_115061800-stock-photo-passport-photo-of-a-young.jpg',
        '11' => 'https://media.gettyimages.com/photos/real-caucasian-man-with-blank-expression-picture-id1081389092?s=2048x2048',
        '12' => 'https://guillaumebarbaz.com/wp-content/uploads/2013/10/IMG_5565_cp_mini.jpg',
        '13' => 'https://thumbs.dreamstime.com/z/portrait-de-jeune-homme-heureux-soulevant-ses-mains
        -97191757.jpg',
        '14' => 'https://as2.ftcdn.net/v2/jpg/00/46/19/27/1000_F_46192720_kbklwHfdvgcKS2rNe5b36s9FwefHJnvt.jpg',
        '15' => 'https://media.gettyimages.com/photos/portrait-of-a-real-english-man-looking-at-camera-picture-id498311622?s=2048x2048',
        '16' => 'https://media.gettyimages.com/photos/real-man-picture-id182166118?s=2048x2048',
        '17' => 'https://ak.picdn.net/shutterstock/videos/21394198/thumb/1.jpg',
        '18' => 'https://ak.picdn.net/shutterstock/videos/7076620/thumb/1.jpg',
        '19' => 'https://thumbs.dreamstime.com/b/femme-mill%C3%A9naire-regardant-la-cam%C3%A9ra-sur-le-fond-
        blanc-image-de-portrait-137947265.jpg',
        '20' => 'https://media.gettyimages.com/photos/real-caucasian-man-with-blank-expression-picture-id1081389160?s=2048x2048'
    ];
    private const FIRSTNAME = [
        '1' => 'Abigaïl',
        '2' => 'Lucas',
        '3' => 'Ariel',
        '4' => 'Jean-Jacques',
        '5' => 'Nadège',
        '6' => 'Gaëtan',
        '7' => 'Joshua',
        '8' => 'Peter',
        '9' => 'Baptiste',
        '10' => 'Aline',
        '11' => 'Julien',
        '12' => 'Jérôme',
        '13' => 'Thomas',
        '14' => 'Sofia',
        '15' => 'Sébastien',
        '16' => 'Adrien',
        '17' => 'Glawdys',
        '18' => 'Alphonse',
        '19' => 'Anne',
        '20' => 'Norbert',
    ];

    private const LASTNAME = [
        '1' => 'Dragaud',
        '2' => 'Morisseau',
        '3' => 'Barraud',
        '4' => 'Pottier',
        '5' => 'Briand',
        '6' => 'Le Garrec',
        '7' => 'Johnson',
        '8' => 'Parker',
        '9' => 'Guérin',
        '10' => 'Belot',
        '11' => 'Lauré',
        '12' => 'Poivrer',
        '13' => 'Merlet',
        '14' => 'Barbot',
        '15' => 'Maisoneuve',
        '16' => 'Roué',
        '17' => 'Herbelot',
        '18' => 'Duflos',
        '19' => 'Leblanc',
        '20' => 'Ferrand'
    ];



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

        for ($i = 1; $i <= (self::PROVIDER_NUMBER); $i++) {
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
            $provider->setPicture(self::PICTURE[$i]);
            $provider->setFirstname(self::FIRSTNAME[$i]);
            $provider->setLastname(self::LASTNAME[$i]);
            $provider->setCompany($this->faker->company);
            $provider->setSocialReason(array_rand(array_flip(self::SOCIAL_REASONS)));
            $provider->setSiret($this->faker->numberBetween(11111, 64000));
            $provider->setVatNumber($this->faker->randomFloat(2, 10, 25));
            $provider->setOpening($this->opening);
            $provider->setMonthlyFrequentation($this->faker->randomDigit());
            $provider->setOtherSite($this->otherSite);
            $provider->setKnowUs(array_rand(array_flip(self::KNOW_US)));
            $provider->setContact($contact);
            $provider->setDescription($description);

            $contact->setAddress($this->faker->address);
            $contact->setZipcode($this->faker->postcode);
            $contact->setCity($this->faker->city);
            $contact->setLongitude($this->faker->randomFloat(4, 1, 5));
            $contact->setLatitude($this->faker->randomFloat(4, 43, 50));
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
