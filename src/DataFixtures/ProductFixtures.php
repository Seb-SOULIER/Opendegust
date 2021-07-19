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
    public const NBR_PROVIDER = 20;
    public const PRODUCT_NUMBER = 4;

    private const PICTURE = [
        '1' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '2' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '3' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '4' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '6' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '7' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '8' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '9' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '10' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '11' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '12' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '13' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '14' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '15' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '16' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '17' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '18' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '19' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '20' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '21' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '22' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '23' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '24' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '25' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '26' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '27' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '28' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '29' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '30' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '31' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '32' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '33' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '34' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '35' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '36' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '37' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '38' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '39' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
        '40' => 'https://tse3.mm.bing.net/th?id=OIP.id5B68gc_5PfpNG0OIeJggHaE8&pid=Api&P=0&w=287&h=192',
    ];
    private const NAME = [
        '1' => 'fromage blanc',
        '2' => 'vin blanc',
        '3' => 'champagne',
        '4' => 'rosé',
        '5' => 'yaoûrt nature',
        '6' => 'yaoûrt bio',
        '7' => 'saucisson',
        '8' => 'saucisses',
        '9' => 'jus de pommes',
        '10' => 'jus de kiwi',
        '11' => 'rhum',
        '12' => 'cognac',
        '13' => 'fromage de chèvre',
        '14' => 'fromage de brebis',
        '15' => 'comté',
        '16' => 'pommes',
        '17' => 'poires',
        '18' => 'melon',
        '19' => 'tomates',
        '20' => 'courgettes',
        '21' => 'carottes',
        '22' => 'poireaux',
        '23' => 'radis',
        '24' => 'bière blonde',
        '25' => 'bière brune',
        '26' => 'bière blanche',
        '27' => 'cidre doux',
        '28' => 'cidre brut',
        '29' => 'ricard',
        '30' => 'paëlla',
        '31' => 'moules/frites',
        '32' => 'spaghettis',
        '33' => 'tortillas',
        '34' => 'homar',
        '35' => 'huïtres',
        '36' => 'coquilles saint-jacques',
        '37' => 'langoustines',
        '38' => 'crabes',
        '39' => 'saumon',
        '40' => 'citron',
    ];
    private const DESCRIPTION = [
        '1' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '2' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '3' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '4' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '5' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '6' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '7' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '8' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '9' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '10' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '11' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '12' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '13' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '14' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '15' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '16' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '17' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '18' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '19' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '20' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '21' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '22' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '23' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '24' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '25' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '26' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '27' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '28' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '29' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '30' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '31' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '32' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '33' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '34' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '35' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '36' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '37' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '38' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '39' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        '40' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
    ];

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for ($a = 1; $a <= self::NBR_PROVIDER; $a++) {
            for ($i = 1; $i <= self::PRODUCT_NUMBER; $i++) {
                $product = new Product();
                $product->setProvider($this->getReference('provider_' . $a));
                $product->setCategory($this->getReference('category_' . rand(7, 20)));
                $product->setName(self::NAME[rand(1, 40)]);
                $product->setDescription(self::DESCRIPTION[rand(1, 40)]);
                $product->setPicture(self::PICTURE[$i]);
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
