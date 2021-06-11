<?php

namespace App\DataFixtures;

use App\Entity\Newsletter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class NewsletterFixtures extends Fixture
{
    private const NEWSLETTER_NUMBER = 50;


    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        for ($i = 1; $i <= self::NEWSLETTER_NUMBER; $i++) {
            $newsletter = new Newsletter();
            $newsletter->setEmail($this->faker->email);
            $manager->persist($newsletter);
        }
        $manager->flush();
    }
}
