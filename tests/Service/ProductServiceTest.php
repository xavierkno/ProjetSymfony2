<?php

namespace App\Tests\Service;

use App\Repository\ProductRepository;
use App\Service\ProductService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductServiceTest extends TestCase
{
    public function testExportCsv()
    {
        /** @var ProductRepository&\PHPUnit\Framework\MockObject\MockObject $productRepository */
        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository->method('findAll')->willReturn([
            (object) ['getName' => 'Produit A', 'getDescription' => 'Description A', 'getPrice' => 25.99],
            (object) ['getName' => 'Produit B', 'getDescription' => 'Description B', 'getPrice' => 10.50]
        ]);

        $productService = new ProductService();
        $response = $productService->exportCSV($productRepository);

        $this->assertInstanceOf(StreamedResponse::class, $response);
    }
}
