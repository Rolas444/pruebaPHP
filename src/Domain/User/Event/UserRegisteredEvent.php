<?php

namespace Domain\User\Event;

use Domain\User\User;

class UserRegisteredEvent {
    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function getUser(): User {
        return $this->user;
    }
}