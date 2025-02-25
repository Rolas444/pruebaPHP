<?php

namespace Application;

use Domain\User\User;
use Domain\User\UserRepositoryInterface;
use Domain\User\UserId;
use Domain\User\UserName;
use Domain\User\UserEmail;
use Domain\User\UserPassword;

class UserService {
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function registerUser(string $id, string $name, string $email, string $password) {
        $userId = new UserId($id);
        $userName = new UserName($name);
        $userEmail = new UserEmail($email);
        $userPassword = new UserPassword($password);
        $user = new User($userId, $userName, $userEmail, $userPassword);
        $this->userRepository->save($user);
    }
}
