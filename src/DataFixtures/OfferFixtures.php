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
        '1' => 'https://cache.cosmopolitan.fr/data/photo/w1000_ci/54/amis-restaurant.webp',
        '2' => 'https://cdn.pixabay.com/photo/2015/01/05/22/29/wellness-589773_960_720.jpg',
        '3' => 'https://www.nordundsud.at/wp-content/uploads/2020/10/Coffrets-degustation-458x458.jpg',
        '4' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '5' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRz815SFgVmz0F1SD685KEczMhF2WLo-tKH8A&usqp=CAU',
        '6' => 'https://www.laroutedesgourmets.fr/831-thickbox_default/degustation-de-fromages-a-paris.jpg',
        '7' => 'https://beecity.fr/app/uploads/2019/10/Ateliers-r%C3%A9colte-du-miel-Photo-Clara-720x790-c-default.jpg',
        '8' => 'https://www.enil.fr/images/illustrations/enil/ateliers/yaourt/ENSEMENCEMENT.JPG',
        '9' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRz815SFgVmz0F1SD685KEczMhF2WLo-tKH8A&usqp=CAU',
        '10' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c7/Curitiba_Botanic_Garden.jpg/330px-Curitiba_Botanic_Garden.jpg',
        '11' => 'https://webservices-storage.lmsoft.com/3248/photogallery/images/pictures/089f8ced6e3c5f88da7a5081c7452b8f.jpg',
        '12' => 'https://biscuitsetcompagnie.com/journal/wp-content/uploads/2017/01/255001000_betises_de_cambrai_a_la_menthe_120g_02.jpg',
        '13' => 'https://www.lafermedesaintbonnet.fr/wp-content/uploads/2016/11/viande-bio-14.jpg',
        '14' => 'https://le-cdn.website-editor.net/c181047c4b0c4afeb69d195e5bd540e1/dms3rep/multi/opt/degustation+de+spiritueux-602w.jpg',
        '15' => 'https://cdn.pixabay.com/photo/2018/03/13/20/08/pistachios-3223610_960_720.jpg',
        '16' => 'https://cdn.pixabay.com/photo/2015/09/21/14/24/supermarket-949913_960_720.jpg',
        '17' => 'https://cdn.pixabay.com/photo/2016/06/19/00/17/raspberries-1465988_960_720.jpg',
        '18' => 'https://cdn.pixabay.com/photo/2017/09/25/20/44/peppers-2786684_960_720.jpg',
        '19' => 'https://cdn.pixabay.com/photo/2018/06/10/20/30/bread-3467243_960_720.jpg',
        '20' => 'https://cdn.pixabay.com/photo/2016/03/05/20/07/salmon-1238662_960_720.jpg',
        '21' => 'https://cdn.pixabay.com/photo/2016/05/13/16/37/muffin-1390368_960_720.jpg',
        '22' => 'https://cdn.pixabay.com/photo/2018/10/16/23/24/mushrooms-3752807_960_720.jpg',
    ];

    private const NAME = [
        '1' => 'D??gustation couverte',
        '2' => 'Visite au ch??teau Aguilard',
        '3' => 'D??gustation de Vin blanc',
        '4' => 'D??gustation de bi??res',
        '5' => 'D??gustation de jambon',
        '6' => 'D??gustation de fromage',
        '7' => 'Atelier d??couverte du miel',
        '8' => 'atelier production de produits laitiers',
        '9' => 'D??gustation produits laitiers',
        '10' => 'D??couverte jardin bottannique',
        '11' => 'Cours de Cuisine en pleine nature',
        '12' => 'D??gustation Friandises locales',
        '13' => 'D??gustation viande bio',
        '14' => 'D??gustation de Spiritueux',
        '15' => 'Atelier Spa',
        '16' => 'D??gustation couverte',
        '17' => 'D??gustation couverte',
        '18' => 'D??gustation couverte',
        '19' => 'D??gustation couverte',
        '20' => 'D??gustation couverte',
        '21' => 'D??gustation couverte',
        '22' => 'D??gustation couverte',
    ];
    private const DOMAINNAME = [
        '1' => 'Domaine 2',
        '2' => 'Domaine 3',
        '3' => 'Domaine 4',
        '4' => 'Domaine 5',
        '5' => 'Domaine 6',
        '6' => 'Domaine 7',
        '7' => 'Domaine 8',
        '8' => 'Domaine 9',
        '9' => 'Domaine 10',
        '10' => 'Domaine 11',
        '11' => 'Domaine 12',
        '12' => 'Domaine 13',
        '13' => 'Domaine 14',
        '14' => 'Domaine 15',
        '15' => 'Domaine 16',
        '16' => 'Domaine 17',
        '17' => 'Domaine 18',
        '18' => 'Domaine 19',
        '19' => 'Domaine 20',
        '20' => 'Domaine 21',
        '21' => 'Domaine 22',
        '22' => 'Domaine 23',
    ];

    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for ($a = 1; $a <= self::NBR_PROVIDER; $a++) {
            for ($i = 1; $i <= self::OFFER_NUMBER; $i++) {
                $offer = new Offer();
                $offer->setName(self::NAME[rand(1, 22)]);
                $offer->setPicture(self::PICTURE[rand(1, 22)]);
                $offer->setDomainName(self::DOMAINNAME[rand(1, 22)]);

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
                $contact->setLongitude($this->faker->randomFloat(4, -0.96, 1.26));
                $contact->setLatitude($this->faker->randomFloat(4, 45.47, 46.32));
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
