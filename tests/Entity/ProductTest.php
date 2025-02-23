<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testCreateProduct()
    {
        $product = new Product();
        $product->setName('Produit Test');
        $product->setDescription('Une super description');
        $product->setPrice(99.99);

        $this->assertEquals('Produit Test', $product->getName());
        $this->assertEquals('Une super description', $product->getDescription());
        $this->assertEquals(99.99, $product->getPrice());
    }
}
