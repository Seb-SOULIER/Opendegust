<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        ['name' => 'Visites et dégustations',
            'children' => [
                ['name' => 'Boisson',
                    'children' => [
                        ['name' => 'Vin et Champagne'],
                        ['name' => 'Brasserie'],
                        ['name' => 'Cidrerie'],
                        ['name' => 'Cognac et Pineau'],
                        ['name' => 'Spiritueux']
                    ]
                ],
                ['name' => 'Gastronomie',
                    'children' => [
                        ['name' => 'Foie gras'],
                        ['name' => 'Charcuterie'],
                        ['name' => 'Fromage'],
                        ['name' => 'Fruits de mer'],
                        ['name' => 'Chocolat'],
                        ['name' => 'Biscuit'],
                        ['name' => 'Confiserie'],
                        ['name' => 'Produits de la Ferme'],
                        ['name' => 'Epicerie et autres produits']
                    ]
                ]
            ]
        ],
        ['name' => 'Activités',
            'children' => [
                ['name' => 'Cours et Ateliers de dégustation'],
                ['name' => 'Cours et Ateliers culinaires'],
                ['name' => 'Balades gourmandes'],
                ['name' => 'Repas vigneron'],
                ['name' => 'Cueillette à la ferme'],
                ['name' => 'Expériences insolites'],
                ['name' => 'Pique nique au château'],
                ['name' => 'Jeux et énigmes au château']
            ]
        ],
        ['name' => 'Evasion',
            'children' => [
                ['name' => 'Séjours immersifs'],
                ['name' => 'Spa'],
                ['name' => 'Tables de spécialités locales']
            ]
        ],
        ['name' => 'Evénement',
            'children' => [
                ['name' => 'Portes ouvertes'],
                ['name' => 'Marchés de producteurs'],
                ['name' => 'Tablées gourmandes et nocturnes'],
                ['name' => 'Evénements locaux']
            ]
        ]
    ];


    public function load(ObjectManager $manager)
    {
        // Génération des catégories mères
        $categoryIndex = 0;
        foreach (self::CATEGORIES as $val) {
            $categoryIndex++;
            $category = new Category();
            $category->setName($val['name']);
            $manager->persist($category);
            $this->addReference('category_' . $categoryIndex, $category);
            if (isset($val['children'])) {
                $this->loadChildren($category, $val['children'], $manager, $categoryIndex);
            }
        }
        $manager->flush();
    }

    private function loadChildren($category, $children, $manager, &$categoryIndex)
    {

        foreach ($children as $child) {
            $categoryIndex++;
            $categoryChild = new Category();
            $categoryChild->setName($child['name']);
            $categoryChild->setCategory($category);
            $manager->persist($categoryChild);
            $this->addReference('category_' . $categoryIndex, $categoryChild);
            if (isset($child['children'])) {
                $this->loadChildren($categoryChild, $child['children'], $manager, $categoryIndex);
            }
        }
    }
}
