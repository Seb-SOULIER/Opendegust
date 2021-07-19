<?php

namespace App\DataFixtures;

use App\Entity\Calendar;
use App\Entity\Category;
use App\Entity\Contact;
use App\Entity\Description;
use App\Entity\Offer;
use App\Entity\OfferVariation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTime;

class OfferFixtures extends Fixture implements DependentFixtureInterface
{
    private const OFFER_NUMBER = 4;
    private const NBR_PROVIDER = 20;
    private const LANGUAGE = [
        ['francais','anglais','espagnol','chinois','japonais','russe','portugais'],
        ['francais','anglais'],
        ['francais','anglais','chinois','japonais'],
        ['francais','russe','portugais'],
        ['espagnol','chinois','japonais','russe','portugais'],
        ['francais','anglais','russe','portugais'],
        ['francais','anglais','espagnol','chinois','japonais','russe'],
        ['francais','anglais','espagnol','russe','portugais'],
        ['francais','anglais','espagnol','chinois','japonais','russe','portugais']
    ];
    private const PICTURE = [
        '0' => 'http://4.bp.blogspot.com/-sOxM1VOF3aw/UFurFiwGKTI/AAAAAAAAD5s/wFABJmlvBHQ/s1600/IMG_4751.JPG',
        '1' => 'https://cache.cosmopolitan.fr/data/photo/w1000_ci/54/amis-restaurant.webp',
        '2' => 'https://via.placeholder.com/640x480.png/00ff22?text=food+quasi',
        '3' => 'https://www.nordundsud.at/wp-content/uploads/2020/10/Coffrets-degustation-458x458.jpg',
        '4' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '5' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRz815SFgVmz0F1SD685KEczMhF2WLo-tKH8A&usqp=CAU',
        '6' => 'https://www.laroutedesgourmets.fr/831-thickbox_default/degustation-de-fromages-a-paris.jpg',
        '7' => 'https://beecity.fr/app/uploads/2019/10/Ateliers-r%C3%A9colte-du-miel-Photo-Clara-720x790-c-default.jpg',
        '8' => 'https://www.enil.fr/images/illustrations/enil/ateliers/yaourt/ENSEMENCEMENT.JPG',
        '9' => 'https://scontent-cdt1-1.xx.fbcdn.net/v/t1.6435-9/86871778_2471299583121891_2194054236088565760_n.jpg?_nc_cat=109&ccb=1-3&_nc_sid=973b4a&_nc_ohc=0kH0jCJH0H0AX_0h7MJ&_nc_ht=scontent-cdt1-1.xx&oh=fb4b0996681a180498dd1b65702775ab&oe=60F556A3',
        '10' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c7/Curitiba_Botanic_Garden.jpg/330px-Curitiba_Botanic_Garden.jpg',
        '11' => 'https://webservices-storage.lmsoft.com/3248/photogallery/images/pictures/089f8ced6e3c5f88da7a5081c7452b8f.jpg',
        '12' => 'https://biscuitsetcompagnie.com/journal/wp-content/uploads/2017/01/255001000_betises_de_cambrai_a_la_menthe_120g_02.jpg',
        '13' => 'https://www.lafermedesaintbonnet.fr/wp-content/uploads/2016/11/viande-bio-14.jpg',
        '14' => 'https://le-cdn.website-editor.net/c181047c4b0c4afeb69d195e5bd540e1/dms3rep/multi/opt/degustation+de+spiritueux-602w.jpg',
        '15' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '16' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '17' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '18' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '19' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '20' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '21' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '22' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
    ];

    private const NAME = [
        '0' => 'Dégustation en plein air',
        '1' => 'Dégustation couverte',
        '2' => 'Visite au château Aguilard',
        '3' => 'Dégustation de Vin blanc',
        '4' => 'Dégustation de bières',
        '5' => 'Dégustation de jambon',
        '6' => 'Dégustation de fromage',
        '7' => 'Atelier découverte du miel',
        '8' => 'atelier production de produits laitiers',
        '9' => 'Dégustation produits laitiers',
        '10' => 'Découverte jardin bottannique',
        '11' => 'Cours de Cuisine en pleine nature',
        '12' => 'Dégustation Friandises locales',
        '13' => 'Dégustation viande bio',
        '14' => 'Dégustation de Spiritueux',
        '15' => 'Atelier Spa',
        '16' => 'Dégustation couverte',
        '17' => 'Dégustation couverte',
        '18' => 'Dégustation couverte',
        '19' => 'Dégustation couverte',
        '20' => 'Dégustation couverte',
        '21' => 'Dégustation couverte',
        '22' => 'Dégustation couverte',
    ];

    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for ($a = 1; $a <= self::NBR_PROVIDER; $a++) {
            for ($i = 1; $i <= self::OFFER_NUMBER; $i++) {
                $offer = new Offer();
                $offer->setName(self::NAME[rand(0, 22)]);
                $offer->setPicture(self::PICTURE[rand(0, 22)]);
                $offer->setDomainName($this->faker->sentence(3));

                $language = self::LANGUAGE[rand(0, 8)];

                $offer->setLanguage($language);
                $offer->setProvider($this->getReference('provider_' . $a));

                $description = new Description();
                $description->setShortDescription($this->faker->sentence(15));
                $description->setLongDescription($this->faker->sentence(50));
                $manager->persist($description);
                $offer->setDescription($description);

                $offer->addCategory($this->getReference('category_' . rand(1, 35)));

                $contact = new Contact();
                $contact->setZipcode($this->faker->postcode);
                $contact->setAddress($this->faker->sentence(3));
                $contact->setCity($this->faker->city);
                $contact->setLongitude($this->faker->randomFloat(4, 1, 5));
                $contact->setLatitude($this->faker->randomFloat(4, 43, 50));
                $contact->setPhone($this->faker->phoneNumber);
                $contact->setPhone2($this->faker->phoneNumber);
                $contact->setWebsite($this->faker->domainName);
                $manager->persist($contact);
                $offer->setContact($contact);

                for ($i = 1; $i <= rand(1, 5); $i++) {
                    $offerVariation = new OfferVariation();
                    $offerVariation->setPriceVariation([
                        'adultes' => rand(1, 50),
                        'enfants' => rand(1, 30)
                    ]);
                    $capacity = rand(1, 50);
                    $offerVariation->setCapacity($capacity);
                    $offerVariation->setDuration((new DateTime())->setTime(rand(0, 10), rand(0, 59)));
                    $offerVariation->setPrice(rand(1, 50));
                    $offerVariation->setCurrentVat(rand(5, 25));
                    $offerVariation->setOffer($offer);
                    $offerVariation->setAvailablePlaces($capacity);

                    for ($i = 1; $i <= rand(1, 5); $i++) {
                        $calendar = new Calendar();
                        $calendar->setOfferVariation($offerVariation);
                        $calendar->setStartAt($this->faker->dateTimeBetween('now', '+ 10 week'));
                        $manager->persist($calendar);
                    }
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
            CategoryFixtures::class,
        ];
    }
}
