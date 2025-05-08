<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Pattern;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PatternFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findAll(); // Liste des catégories
        $faker = Factory::create('fr_FR');
        $users = $manager->getRepository(User::class)->findAll(); // Liste des utilisateurs

        for ($i = 0; $i < 50; $i++) {
            $category = $faker->randomElement($categories); // On choisit une catégorie aléatoire
            $categoryName = $category->getName(); // On récupère son nom

            $pattern = new Pattern();
            $title = $categoryName . ' ' . ucfirst($faker->word()); // Construction du titre

            $pattern
                ->setTitle($title) // Titre du patron
                ->setImage(null) // Pas d'image pour l'instant
                ->setAuthor($faker->name()) // Auteur aléatoire
                ->setIsPrinted($faker->boolean()) // Imprimé ou non
                ->setIsRealized($faker->boolean()) // Réalisé ou non
                ->setDateRealized(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', 'now'))) // Date de réalisation
                ->setCommentary($faker->text()) // Commentaires aléatoires
                ->setCategory($category) // C'est ici qu'on associe l'objet `Category`
                ->setUser($faker->randomElement($users)); // Un utilisateur aléatoire

            $manager->persist($pattern);
        }

        $manager->flush(); // Sauvegarde des entités
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class, UserFixtures::class]; // Dépendances pour charger les catégories et les utilisateurs avant
    }
}
