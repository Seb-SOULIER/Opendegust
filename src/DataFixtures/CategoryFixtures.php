<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORY = [
        ['name' => 'Visites et dégustations','parentId' => null],
        ['name' => 'Activités','parentId' => null],
        ['name' => 'Evasion','parentId' => null],
        ['name' => 'Evénement','parentId' => null],
        ['name' => 'Boisson','parentId' => 1],
        ['name' => 'Gastronomie','parentId' => 1],
        ['name' => 'Vin et Champagne','parentId' => 5],
        ['name' => 'Brasserie','parentId' => 5],
        ['name' => 'Cidrerie','parentId' => 5],
        ['name' => 'Cognac et Pineau','parentId' => 5],
        ['name' => 'Spiritueux','parentId' => 5],
        ['name' => 'Foie gras','parentId' => 6],
        ['name' => 'Charcuterie','parentId' => 6],
        ['name' => 'Fromage','parentId' => 6],
        ['name' => 'Fruits de mer','parentId' => 6],
        ['name' => 'Chocolat','parentId' => 6],
        ['name' => 'Biscuit','parentId' => 6],
        ['name' => 'Confiserie','parentId' => 6],
        ['name' => 'Produits de la Ferme','parentId' => 6],
        ['name' => 'Epicerie et autres produits','parentId' => 6],
        ['name' => 'Cours et Ateliers de dégustation','parentId' => 2],
        ['name' => 'Cours et Ateliers culinaires','parentId' => 2],
        ['name' => 'Balades gourmandes','parentId' => 2],
        ['name' => 'Repas vigneron','parentId' => 2],
        ['name' => 'Cueillette à la ferme','parentId' => 2],
        ['name' => 'Expériences insolites','parentId' => 2],
        ['name' => 'Pique nique au château','parentId' => 2],
        ['name' => 'Jeux et énigmes au château','parentId' => 2],
        ['name' => 'Séjours immersifs','parentId' => 3],
        ['name' => 'Spa','parentId' => 3],
        ['name' => 'Tables de spécialités locales','parentId' => 3],
        ['name' => 'Portes ouvertes','parentId' => 4],
        ['name' => 'Marchés de producteurs','parentId' => 4],
        ['name' => 'Tablées gourmandes et nocturnes','parentId' => 4],
        ['name' => 'Evénements locaux','parentId' => 4]
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORY as $key => $tableCategory) {
            $category = new Category();
            $category->setName($tableCategory['name']);
            $category->setParentId($tableCategory['parentId']);
            $this->addReference('category_' . $key, $category);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
