<?php

namespace Infrastructure\Persistence;

use Domain\User\User;
use Domain\User\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Domain\User\UserId;
use Domain\User\UserEmail;

class DoctrineUserRepository implements UserRepositoryInterface {
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function save(User $user): void {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findById(UserId $id): ?User {
        return $this->entityManager->find(User::class, $id);
    }

    public function findByEmail(UserEmail $email): ?User {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email->getValue()]);
    }

    public function delete(UserId $id): void {
        $user = $this->entityManager->find(User::class, $id);
        if ($user !== null) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }
    }
}
