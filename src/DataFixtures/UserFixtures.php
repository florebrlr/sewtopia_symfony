<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setEmail($faker->email())
                ->setRoles(["ROLE_USER"])
                ->setUsername($faker->userName())
                ->setPassword(
                    $this->userPasswordHasher->hashPassword($user, "1234")
                );

            $manager->persist($user);
        }
    }
}
