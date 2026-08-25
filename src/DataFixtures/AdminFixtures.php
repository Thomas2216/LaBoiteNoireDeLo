<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Admin();
        $admin->setEmail('admin@laurajoly.fr');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'ChangeMe1234!'));

        $manager->persist($admin);
        $manager->flush();
    }
}
