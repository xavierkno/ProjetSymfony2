<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreateUser()
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setFirstname('John');
        $user->setLastname('Doe');
        $user->setRoles(['ROLE_USER']);

        $this->assertEquals('test@example.com', $user->getEmail());
        $this->assertEquals('John', $user->getFirstname());
        $this->assertEquals('Doe', $user->getLastname());
        $this->assertContains('ROLE_USER', $user->getRoles());
    }
}
