<?php

namespace Domain\User;

use Domain\User\Exception\WeakPasswordException;

class UserPassword {
    private $hashedPassword;

    public function __construct(string $password) {
        if (!$this->isValidPassword($password)) {
            throw new WeakPasswordException();
        }
        $this->hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    }

    private function isValidPassword(string $password): bool {
        return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
    }

    public function getHashedPassword(): string {
        return $this->hashedPassword;
    }

    public function validate(string $password): bool {
        return password_verify($password, $this->hashedPassword);
    }
}
