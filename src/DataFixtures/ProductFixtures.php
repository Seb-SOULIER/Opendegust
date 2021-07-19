<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTime;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public const NBR_PROVIDER = 10;
    public const PRODUCT_NUMBER = 4;

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
        '23' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '24' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '25' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '26' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '27' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '28' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '29' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '30' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '31' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '32' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '33' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '34' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '35' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '36' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '37' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '38' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
        '39' => 'https://uploads.lebonbon.fr/source/2019/january/a930ptnfne_2_675.jpg',
    ];
    private const NAME = [
        '0' => '1',
        '1' => '2',
        '2' => '3',
        '3' => '4',
        '4' => '5',
        '5' => '6',
        '6' => '7',
        '7' => '8',
        '8' => '9',
        '9' => '10',
        '10' => '11',
        '11' => '12',
        '12' => '13',
        '13' => '14',
        '14' => '15',
        '15' => '16',
        '16' => '17',
        '17' => '18',
        '18' => '19',
        '19' => '20',
        '20' => '21',
        '21' => '22',
        '22' => '23',
        '23' => '24',
        '24' => '25',
        '25' => '26',
        '26' => '27',
        '27' => '28',
        '28' => '29',
        '29' => '30',
        '30' => '31',
        '31' => '32',
        '32' => '33',
        '33' => '34',
        '34' => '35',
        '35' => '36',
        '36' => '37',
        '37' => '38',
        '38' => '39',
        '39' => '40',
    ];

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for ($a = 1; $a <= self::NBR_PROVIDER; $a++) {
            for ($i = 1; $i <= self::PRODUCT_NUMBER; $i++) {
                $product = new Product();
                $product->setProvider($this->getReference('provider_' . $a));
                $product->setCategory($this->getReference('category_' . rand(7, 20)));
                $product->setName(self::NAME[rand(0, 39)]);
                $product->setDescription($this->faker->sentence(15));
                $product->setPicture(self::PICTURE[rand(0, 39)]);
                $product->setPrice($this->faker->randomFloat(2, 10, 25));
                $manager->persist($product);
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
