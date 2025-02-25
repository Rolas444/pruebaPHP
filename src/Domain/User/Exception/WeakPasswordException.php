<?php

namespace Domain\User\Exception;

class WeakPasswordException extends \Exception {
    protected $message = 'Password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.';
}