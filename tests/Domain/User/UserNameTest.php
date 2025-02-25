<?php

namespace Tests\Domain\User;

use Domain\User\UserName;
use PHPUnit\Framework\TestCase;

class UserNameTest extends TestCase {
    public function testValidUserName(): void {
        $userName = new UserName('JohnDoe');
        $this->assertEquals('JohnDoe', $userName->getValue());
    }

    public function testInvalidUserNameTooShort(): void {
        $this->expectException(\InvalidArgumentException::class);
        new UserName('Jo');
    }

    public function testInvalidUserNameWithNumbers(): void {
        $this->expectException(\InvalidArgumentException::class);
        new UserName('John123');
    }
}