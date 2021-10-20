<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) { }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setEmail('doguakkaya27@gmail.com')
            ->setPassword($this->passwordHasher->hashPassword($user, '123qwe'));

        $manager->persist($user);

        $manager->flush();
    }
}
