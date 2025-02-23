<?php

namespace App\Tests\Entity;

use App\Entity\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testCreateClient()
    {
        $client = new Client();
        $client->setFirstname('Alice');
        $client->setLastname('Dupont');
        $client->setEmail('alice@example.com');
        $client->setPhoneNumber('0623456789');
        $client->setAddress('123 Rue de Paris');

        $this->assertEquals('Alice', $client->getFirstname());
        $this->assertEquals('Dupont', $client->getLastname());
        $this->assertEquals('alice@example.com', $client->getEmail());
        $this->assertEquals('0623456789', $client->getPhoneNumber());
        $this->assertEquals('123 Rue de Paris', $client->getAddress());
        $this->assertInstanceOf(\DateTimeImmutable::class, $client->getCreatedAt());
    }
}
