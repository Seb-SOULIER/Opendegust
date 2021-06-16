<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private const NBR_PROVIDER = 50;
    private const PRODUCT_NUMBER = 4;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for ($a = 1; $a <= self::NBR_PROVIDER; $a++) {
            for ($i = 1; $i <= self::PRODUCT_NUMBER; $i++) {
                $product = new Product();
                $product->setProvider($this->getReference('provider_' . $a));
                $product->setCategory($this->getReference('category_' . $i));
                $product->setName($this->faker->sentence(1));
                $product->setDescription($this->faker->sentence(15));
                $product->setPicture($this->faker->imageUrl(480, 640, 'animals', true));
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
