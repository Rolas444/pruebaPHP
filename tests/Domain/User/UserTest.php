<?php

namespace Tests\Domain\User;

use Domain\User\User;
use Domain\User\UserEmail;
use Domain\User\UserId;
use Domain\User\UserName;
use Domain\User\UserPassword;
use PHPUnit\Framework\TestCase;



class UserTest extends TestCase {
    public function testUserCreation(): void {
        $userId = new UserId('1');
        $userName = new UserName('JohnDoe');
        $userEmail = new UserEmail('john.doe@example.com');
        $userPassword = new UserPassword('Password123!');

        $user = new User($userId, $userName, $userEmail, $userPassword);

        $this->assertEquals('1', $user->getId()->getValue());
        $this->assertEquals('JohnDoe', $user->getName()->getValue());
        $this->assertEquals('john.doe@example.com', $user->getEmail()->getValue());
        $this->assertTrue($userPassword->validate('Password123!'));
    }
}