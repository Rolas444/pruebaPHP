<?php

namespace Domain\User;

use Domain\User\Exception\InvalidEmailException;

class UserEmail {
    private $value;

    public function __construct(string $value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }
}
