<?php

namespace App\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use League\Csv\Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-products',
    description: 'Importe une liste de produits à partir d\'un fichier CSV',
)]
class ImportProductsCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = 'public/uploads/products.csv'; 

        if (!file_exists($filePath)) {
            $io->error('Le fichier CSV n\'existe pas. Placez-le dans "public/uploads/products.csv".');
            return Command::FAILURE;
        }

        try {
            $csv = Reader::createFromPath($filePath, 'r');
            $csv->setDelimiter(';'); 
            $csv->setHeaderOffset(0); 


            $io->info('Colonnes détectées dans le fichier CSV : ' . implode(', ', $csv->getHeader()));
            foreach ($csv as $record) {
                if (!isset($record['name'], $record['description'], $record['price'])) {
                    $io->error('Le fichier CSV ne contient pas les colonnes attendues (name, description, price). Vérifiez votre fichier.');
                    return Command::FAILURE;
                }
            
                $name = trim($record['name']);
                $description = trim($record['description']);
                $price = (float) str_replace(',', '.', $record['price']); 
            

                if (empty($name) || empty($description) || $price <= 0) {
                    $io->warning("Ligne ignorée : données invalides (Name: $name, Price: $price)");
                    continue;
                }

                $product = new Product();
                $product->setName($name);
                $product->setDescription($description);
                $product->setPrice($price);

                $this->entityManager->persist($product);
            }

            $this->entityManager->flush();
            $io->success('Importation terminée avec succès !');
            return Command::SUCCESS;
        } catch (Exception $e) {
            $io->error('Erreur lors de la lecture du fichier CSV : ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
