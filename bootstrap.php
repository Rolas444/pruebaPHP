<?php

require_once __DIR__ . '/vendor/autoload.php';

use Infrastructure\Event\EventDispatcher;
use Application\EventListener\UserEventListener;
use Application\UseCase\RegisterUserUseCase;
use Domain\User\UserRepositoryInterface;
use Infrastructure\Persistence\Doctrine\UserRepository as DoctrineUserRepository;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Domain\User\Event\UserRegisteredEvent;
use Dotenv\Dotenv;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;

require __DIR__ . '/doctrine.php';


// Crear el EntityManager
$entityManager = getEntityManager();

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
