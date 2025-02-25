<?php

namespace Domain\User\Exception;

class UserAlreadyExistsException extends \Exception {
    protected $message = 'A user with this email already exists.';
}