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
                'name' => 'Laptop',
                'description' => 'A high-performance laptop for professionals.',
                'price' => 1200.99,
            ],
            [
                'name' => 'Smartphone',
                'description' => 'A latest generation smartphone with advanced features.',
                'price' => 799.99,
            ],
            [
                'name' => 'Tablet',
                'description' => 'A lightweight tablet for everyday use.',
                'price' => 499.99,
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