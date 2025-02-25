<?php

namespace Tests\Application\UseCase;

use Application\DTO\RegisterUserRequest;
use Application\UseCase\RegisterUserUseCase;
use Domain\User\Event\UserRegisteredEvent;
use Domain\User\Exception\UserAlreadyExistsException;
use Domain\User\User;
use Domain\User\UserEmail;
use Domain\User\UserId;
use Domain\User\UserName;
use Domain\User\UserPassword;
use Domain\User\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class RegisterUserUseCaseTest extends TestCase {
    private $userRepository;
    private $eventDispatcher;
    private $registerUserUseCase;

    protected function setUp(): void {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->registerUserUseCase = new RegisterUserUseCase($this->userRepository, $this->eventDispatcher);
    }

    public function testRegisterUserSuccessfully(): void {
        $request = new RegisterUserRequest('1', 'JohnDoe', 'john.doe@example.com', 'Password123!');

        $this->userRepository->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);

        $this->userRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(UserRegisteredEvent::class));

        $this->registerUserUseCase->execute($request);
    }

    public function testRegisterUserWithExistingEmail(): void {
        $this->expectException(UserAlreadyExistsException::class);

        $request = new RegisterUserRequest('1', 'JohnDoe', 'john.doe@example.com', 'Password123!');

        $this->userRepository->expects($this->once())
            ->method('findByEmail')
            ->willReturn(new User(
                new UserId('1'),
                new UserName('JohnDoe'),
                new UserEmail('john.doe@example.com'),
                new UserPassword('Password123!')
            ));

        $this->registerUserUseCase->execute($request);
    }
}