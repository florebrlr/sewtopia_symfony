<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = ['Accessoires', 'Blouse', 'Chemise', 'Cosplay', 'Divers', 'Jupe', 'Lingerie', 'Maillot de bain', 'Maison', 'Manteau', 'Pantalon', 'Pyjama', 'Robe', 'Sport Wear', 'Sweat & Pull', 'Top','Tshirt','Veste'];

        foreach ($categories as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }
        $manager->flush();
    }
}