<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Infrastructure\Event\EventDispatcher;
use Application\EventListener\UserEventListener;
use Application\UseCase\RegisterUserUseCase;
use Domain\User\UserRepositoryInterface;
use Infrastructure\Persistence\DoctrineUserRepository;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Domain\User\Event\UserRegisteredEvent;
use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

// Crear el EntityManager
$entityManager = getEntityManager(); // Asegúrate de tener esta función definida en tu configuración de Doctrine

// Crear el EventDispatcher
$eventDispatcher = new EventDispatcher();

// Crear el Logger
$logger = new NullLogger(); // Reemplaza con una implementación real de LoggerInterface

// Crear y registrar el listener
$userEventListener = new UserEventListener($logger);
$eventDispatcher->addListener(UserRegisteredEvent::class, [$userEventListener, 'onUserRegistered']);

// Crear el UserRepository
$userRepository = new DoctrineUserRepository($entityManager);

// Crear el caso de uso
$registerUserUseCase = new RegisterUserUseCase($userRepository, $eventDispatcher);
