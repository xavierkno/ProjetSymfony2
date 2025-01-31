<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'email' => 'admin@gmail.com',
                'password' => 'admin123',
                'roles' => ['ROLE_ADMIN'],
                'firstname' => 'Georges',
                'lastname' => 'Bourgeois',
            ],
            [
                'email' => 'user1@gmail.com',
                'password' => 'user123',
                'roles' => ['ROLE_USER'],
                'firstname' => 'Bertrand',
                'lastname' => 'Chuquet',
            ],
            [
                'email' => 'manager@gmail.com',
                'password' => 'user123',
                'roles' => ['ROLE_MANAGER'],
                'firstname' => 'Raphaël',
                'lastname' => 'Charpentier',
            ],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setRoles($userData['roles']);
            $user->setPassword($this->passwordHasher->hashPassword($user, $userData['password']));
            $user->setFirstname($userData['firstname']);
            $user->setLastname($userData['lastname']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}