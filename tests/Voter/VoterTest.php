<?php

namespace App\Tests\Security\Voter;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Client;
use App\Security\Voter\UserVoter;
use App\Security\Voter\ProductVoter;
use App\Security\Voter\ClientVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class VoterTest extends TestCase
{
    private function getToken(User $user): UsernamePasswordToken
    {
        return new UsernamePasswordToken($user, 'main', $user->getRoles());
    }

    public function testAdminCanManageUsers()
    {
        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $user = new User();
        $token = $this->getToken($admin);

        $voter = new UserVoter();
        $this->assertEquals(1, $voter->vote($token, $user, [UserVoter::EDIT]));
        $this->assertEquals(1, $voter->vote($token, $user, [UserVoter::DELETE]));
    }

    public function testManagerCannotViewUsers()
    {
        $manager = new User();
        $manager->setRoles(['ROLE_MANAGER']);
        $user = new User();
        $token = $this->getToken($manager);

        $voter = new UserVoter();
        $this->assertEquals(-1, $voter->vote($token, $user, [UserVoter::VIEW]));
        $this->assertEquals(-1, $voter->vote($token, $user, [UserVoter::EDIT]));
    }

    public function testUserCannotManageUsers()
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $token = $this->getToken($user);

        $voter = new UserVoter();
        $this->assertEquals(-1, $voter->vote($token, $user, [UserVoter::EDIT]));
        $this->assertEquals(-1, $voter->vote($token, $user, [UserVoter::DELETE]));
    }

    public function testAdminCanManageProducts()
    {
        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $product = new Product();
        $token = $this->getToken($admin);

        $voter = new ProductVoter();
        $this->assertEquals(1, $voter->vote($token, $product, [ProductVoter::EDIT]));
        $this->assertEquals(1, $voter->vote($token, $product, [ProductVoter::DELETE]));
    }

    public function testUserCannotViewProducts()
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $product = new Product();
        $token = $this->getToken($user);

        $voter = new ProductVoter();
        $this->assertEquals(-1, $voter->vote($token, $product, [ProductVoter::VIEW]));
        $this->assertEquals(-1, $voter->vote($token, $product, [ProductVoter::EDIT]));
    }

    public function testAdminAndManagerCanManageClients()
    {
        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $manager = new User();
        $manager->setRoles(['ROLE_MANAGER']);
        $client = new Client();

        $adminToken = $this->getToken($admin);
        $managerToken = $this->getToken($manager);

        $voter = new ClientVoter();
        $this->assertEquals(1, $voter->vote($adminToken, $client, [ClientVoter::EDIT]));
        $this->assertEquals(1, $voter->vote($managerToken, $client, [ClientVoter::EDIT]));
    }

    public function testUserCannotManageClients()
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $client = new Client();
        $token = $this->getToken($user);

        $voter = new ClientVoter();
        $this->assertEquals(-1, $voter->vote($token, $client, [ClientVoter::EDIT]));
        $this->assertEquals(-1, $voter->vote($token, $client, [ClientVoter::DELETE]));
    }
}
