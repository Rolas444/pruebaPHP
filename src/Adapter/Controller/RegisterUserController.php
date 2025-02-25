<?php

namespace Adapter\Controller;

use Application\UseCase\RegisterUserUseCase;
use Application\DTO\RegisterUserRequest;
use Application\DTO\UserResponseDTO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;

class RegisterUserController {
    private RegisterUserUseCase $registerUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase) {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface {
        $data = $request->getParsedBody();

        $registerUserRequest = new RegisterUserRequest(
            $data['id'],
            $data['name'],
            $data['email'],
            $data['password']
        );

        $this->registerUserUseCase->execute($registerUserRequest);

        $userResponseDTO = new UserResponseDTO(
            $data['id'],
            $data['name'],
            $data['email'],
            (new \DateTimeImmutable())->format('Y-m-d H:i:s')
        );

        return new JsonResponse($userResponseDTO->toArray());
    }
}