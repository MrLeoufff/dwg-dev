<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création de l'administrateur
        $admin = new User();
        $admin->setPseudo('DrWeb');
        $admin->setEmail('developpeur.web.gard@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setVerified(true);

        // Hashage du mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'Renstel#84');
        $admin->setPassword($hashedPassword);

        // Persister l'administrateur dans la base de données
        $manager->persist($admin);

        // Exécuter les changements
        $manager->flush();
    }
}
