<?php

namespace Domain\User\Exception;

class InvalidEmailException extends \Exception {
    protected $message = 'The provided email is invalid.';
}