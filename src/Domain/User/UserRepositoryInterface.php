<?php

namespace Domain\User;

interface UserRepositoryInterface {
    public function save(User $user): void;
    public function findById(UserId $id): ?User;
    public function findByEmail(UserEmail $email): ?User;
    public function delete(UserId $id): void;
}
