<?php namespace App\Tests\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * User Model Tests
     * @test
     */
    public function testUser()
    {
        $user = new User();

        $user->setEmail('test@test.com');
        $this->assertEquals($user->getEmail(), 'test@test.com');

        $user->setUsername('tester');
        $this->assertEquals($user->getUsername(), 'tester');

        $user->setPassword('test');
        $this->assertEquals($user->getPassword(), 'test');

        $user->setPlainPassword('test');
        $this->assertEquals($user->getPlainPassword(), 'test');

        $date = new \DateTime();

        $user->setCreatedAt($date);
        $this->assertEquals($user->getCreatedAt(), $date);

        $user->setUpdatedAt($date);
        $this->assertEquals($user->getUpdatedAt(), $date);
    }

}