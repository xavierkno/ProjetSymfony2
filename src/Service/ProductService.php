<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductService
{
    public function exportCSV(ProductRepository $productRepository): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($productRepository) {
            $handle = fopen('php://output', 'w+');

            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, ['Nom', 'Description', 'Prix'], ';');

            foreach ($productRepository->findAll() as $product) {
                fputcsv($handle, [
                    $product->getName(),
                    $product->getDescription(),
                    number_format($product->getPrice(), 2, ',', '') . ' €'
                ], ';');
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="produits.csv"');

        return $response;
    }
}
