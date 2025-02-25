<?php

namespace Tests\Domain\User;

use Domain\User\UserPassword;
use Domain\User\Exception\WeakPasswordException;
use PHPUnit\Framework\TestCase;

class UserPasswordTest extends TestCase {
    public function testValidPassword(): void {
        $password = new UserPassword('Password123!');
        $this->assertTrue($password->validate('Password123!'));
    }

    public function testWeakPassword(): void {
        $this->expectException(WeakPasswordException::class);
        new UserPassword('weak');
    }
}