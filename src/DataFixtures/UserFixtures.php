<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {}

    public function load(ObjectManager $manager): void
    {
        $credo = (new User())
            ->setEmail('credo@example.com')
            ->setRoles(['ROLE_ADMIN'])
        ;
        $credo->setPassword($this->userPasswordHasher->hashPassword($credo, 'credo'));

        $adrien = (new User())
            ->setEmail('adrien@sensiolabs.com')
            ->setRoles(['ROLE_ADMIN'])
        ;
        $adrien->setPassword($this->userPasswordHasher->hashPassword($adrien, 'adrien'));

        $jhon = (new User())->setEmail('jhon@example.com');
        $jhon->setPassword($this->userPasswordHasher->hashPassword($adrien, 'jhon'));

        $manager->persist($credo);
        $manager->persist($adrien);
        $manager->persist($jhon);

        $manager->flush();
    }
}
