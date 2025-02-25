<?php

namespace Application\UseCase;

use Domain\User\Exception\UserAlreadyExistsException;
use Domain\User\User;
use Domain\User\UserId;
use Domain\User\UserName;
use Domain\User\UserEmail;
use Domain\User\UserPassword;
use Domain\User\UserRepositoryInterface;
use Domain\User\Event\UserRegisteredEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Application\DTO\RegisterUserRequest;

class RegisterUserUseCase {
    private UserRepositoryInterface $userRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(UserRepositoryInterface $userRepository, EventDispatcherInterface $eventDispatcher) {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(RegisterUserRequest $request): void {
        // Validar que el email no esté en uso
        if ($this->userRepository->findByEmail(new UserEmail($request->email)) !== null) {
            throw new UserAlreadyExistsException();
        }

        // Crear el nuevo usuario
        $user = new User(
            new UserId($request->id),
            new UserName($request->name),
            new UserEmail($request->email),
            new UserPassword($request->password)
        );

        // Guardar el usuario en el repositorio
        $this->userRepository->save($user);

        // Disparar el evento de dominio
        $event = new UserRegisteredEvent($user);
        $this->eventDispatcher->dispatch($event);
    }
}