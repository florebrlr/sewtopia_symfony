<?php

namespace App\DataFixtures;

use App\Entity\Pattern;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PatternFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findAll();
        $faker = Factory::create('fr_FR');
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 50; $i++) {

            $pattern = new Pattern();
            $pattern
                ->setTitle($faker->word())
                ->setImage("image.png")
                ->setAuthor($faker->name())
                ->setIsPrinted($faker->boolean())
                ->setIsRealized($faker->boolean())
                ->setDateRealized(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', 'now')))
                ->setCommentary($faker->text())
                ->setCategory($faker->randomElement($categories))
                ->setUser($faker->randomElement($users));
            $manager->persist($pattern);

        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [CategoryFixtures::class, UserFixtures::class];
    }
}
