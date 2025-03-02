<?php

namespace App\Command;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[AsCommand(
    name: 'app:add-client',
    description: 'Ajoute un client via la ligne de commande',
)]
class AddClientCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        do {
            $firstname = $helper->ask($input, $output, new Question('Prénom : '));
            $violations = $this->validator->validate($firstname, [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^[a-zA-ZÀ-ÿ\- ]+$/',
                    'message' => 'Le prénom ne peut contenir que des lettres et espaces.',
                ])
            ]);
            if (count($violations) > 0) {
                $io->error($violations[0]->getMessage());
            }
        } while (count($violations) > 0);

        do {
            $lastname = $helper->ask($input, $output, new Question('Nom : '));
            $violations = $this->validator->validate($lastname, [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^[a-zA-ZÀ-ÿ\- ]+$/',
                    'message' => 'Le nom ne peut contenir que des lettres et espaces.',
                ])
            ]);
            if (count($violations) > 0) {
                $io->error($violations[0]->getMessage());
            }
        } while (count($violations) > 0);

        do {
            $email = $helper->ask($input, $output, new Question('Email : '));
        
            $violations = $this->validator->validate($email, [
                new Assert\NotBlank(),
                new Assert\Email(message: 'L\'email "{{ value }}" n\'est pas valide.'),
            ]);
        
            $existingClient = $this->entityManager->getRepository(Client::class)->findOneBy(['email' => $email]);
        
            if ($existingClient) {
                $io->error('Cet email est déjà utilisé par un autre client.');
                $valid = false;
            } elseif (count($violations) > 0) {
                $io->error($violations[0]->getMessage());
                $valid = false;
            } else {
                $valid = true; 
            }
        
        } while (!$valid);
        

        do {
            $phone = $helper->ask($input, $output, new Question('Téléphone : '));
        
            $violations = $this->validator->validate($phone, [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^\+?[0-9 ]+$/',
                    'message' => 'Le numéro de téléphone doit contenir uniquement des chiffres et espaces.',
                ])
            ]);
        
            $existingPhone = $this->entityManager->getRepository(Client::class)->findOneBy(['phoneNumber' => $phone]);
        
            if ($existingPhone) {
                $io->error('Ce numéro de téléphone est déjà utilisé par un autre client.');
                $valid = false;
            } elseif (count($violations) > 0) {
                $io->error($violations[0]->getMessage());
                $valid = false;
            } else {
                $valid = true;
            }
        
        } while (!$valid);

        do {
            $address = $helper->ask($input, $output, new Question('Adresse : '));
            $violations = $this->validator->validate($address, [
                new Assert\NotBlank(),
            ]);
            if (count($violations) > 0) {
                $io->error($violations[0]->getMessage());
            }
        } while (count($violations) > 0);

        $client = new Client();
        $client->setFirstname($firstname);
        $client->setLastname($lastname);
        $client->setEmail($email);
        $client->setPhoneNumber($phone);
        $client->setAddress($address);

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        $io->success('Client ajouté avec succès !');
        return Command::SUCCESS;
    }
}
