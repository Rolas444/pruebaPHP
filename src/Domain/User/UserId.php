<?php

namespace Domain\User;

class UserId {
    private $value;

    public function __construct(string $value) {
        if (empty($value)) {
            throw new \InvalidArgumentException('User ID cannot be empty.');
        }
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }
}
