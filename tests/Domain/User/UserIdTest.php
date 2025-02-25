<?php

namespace Tests\Domain\User;

use Domain\User\UserId;
use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase {
    public function testUserIdCreation(): void {
        $userId = new UserId('338');
        $this->assertEquals('338', $userId->getValue());
    }
}