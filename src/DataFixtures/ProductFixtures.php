<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            [
                'name' => 'Souris Ergonomique',
                'description' => 'Souris sans fil ergonomique avec capteur optique haute précision',
                'price' => 49.99,
            ],
            [
                'name' => "Imprimante Jet d'Encre",
                'description' => 'Imprimante multifonction avec scanner intégré et WiFi',
                'price' => 149.99,
            ],
            [
                'name' => 'Webcam HD 1080p',
                'description' => 'Webcam haute définition avec microphone intégré',
                'price' => 79.99,
            ],
            [
                'name' => 'Clé USB 128 Go',
                'description' => 'Clé USB haute vitesse avec technologie 3.1',
                'price' => 29.99,
            ],
            [
                'name' => 'Écran LED 24 pouces',
                'description' => 'Moniteur LED Full HD avec dalle IPS',
                'price' => 179.99,
            ],
            [
                'name' => 'Tablette Graphique',
                'description' => 'Tablette graphique professionnelle avec stylet haute précision',
                'price' => 249.99,
            ],
            [
                'name' => 'Enceinte Bluetooth',
                'description' => 'Enceinte portable avec basses puissantes et autonomie 10h',
                'price' => 129.99,
            ],
            [
                'name' => 'Disque SSD 1 To',
                'description' => 'Disque SSD ultra-rapide pour un démarrage instantané',
                'price' => 149.99,
            ],
            [
                'name' => 'Chargeur Sans Fil',
                'description' => 'Chargeur sans fil rapide compatible avec tous les smartphones',
                'price' => 39.99,
            ],
            [
                'name' => 'Lampe LED USB',
                'description' => 'Lampe de bureau avec lumière ajustable et port USB intégré',
                'price' => 19.99,
            ],
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setDescription($productData['description']);
            $product->setPrice($productData['price']);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
