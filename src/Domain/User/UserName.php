<?php

namespace Domain\User;

class UserName {
    private $value;

    public function __construct(string $value) {
        if (strlen($value) < 3) {
            throw new \InvalidArgumentException('User name must be at least 3 characters long.');
        }
        if (!preg_match('/^[a-zA-Z]+$/', $value)) {
            throw new \InvalidArgumentException('User name can only contain letters.');
        }
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }
}
