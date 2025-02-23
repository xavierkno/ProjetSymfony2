<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $clientsData = [
            ['Jean', 'Dupont', 'jean.dupont@example.com', '0611223344', '12 rue de la Paix, Paris'],
            ['Sophie', 'Martin', 'sophie.martin@example.com', '0622334455', '45 avenue des Champs, Lyon'],
            ['Marc', 'Lemoine', 'marc.lemoine@example.com', '0633445566', '78 boulevard Haussmann, Marseille'],
            ['Élodie', 'Bernard', 'elodie.bernard@example.com', '0644556677', '23 impasse des Lilas, Toulouse'],
            ['Thomas', 'Durand', 'thomas.durand@example.com', '0655667788', '89 rue Lafayette, Nice'],
            ['Isabelle', 'Moreau', 'isabelle.moreau@example.com', '0666778899', '6 place de la Comédie, Bordeaux'],
            ['David', 'Lambert', 'david.lambert@example.com', '0677889900', '34 quai des Chartrons, Lille'],
            ['Claire', 'Fournier', 'claire.fournier@example.com', '0688990011', '90 rue de la République, Strasbourg'],
            ['Nicolas', 'Girard', 'nicolas.girard@example.com', '0699001122', '55 boulevard Saint-Michel, Nantes'],
            ['Laura', 'Rousseau', 'laura.rousseau@example.com', '0610111213', '14 rue Victor Hugo, Montpellier']
        ];

        foreach ($clientsData as $data) {
            $client = new Client();
            $client->setFirstname($data[0]);
            $client->setLastname($data[1]);
            $client->setEmail($data[2]);
            $client->setPhoneNumber($data[3]);
            $client->setAddress($data[4]);

            $manager->persist($client);
        }

        $manager->flush();
    }
}
