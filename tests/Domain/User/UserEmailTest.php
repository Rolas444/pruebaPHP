<?php

namespace Tests\Domain\User;

use Domain\User\UserEmail;
use Domain\User\Exception\InvalidEmailException;
use PHPUnit\Framework\TestCase;

class UserEmailTest extends TestCase {
    public function testValidEmail(): void {
        $email = new UserEmail('john.doe@example.com');
        $this->assertEquals('john.doe@example.com', $email->getValue());
    }

    public function testInvalidEmail(): void {
        $this->expectException(InvalidEmailException::class);
        new UserEmail('invalid-email');
    }
}