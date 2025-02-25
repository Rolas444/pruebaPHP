<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Adapter/Config/bootstrap.php';

require '../src/Adapter/Config/doctrine.php';
require '../src/Domain/User/User.php';
require '../src/Domain/User/UserId.php';
require '../src/Domain/User/UserName.php';
require '../src/Domain/User/UserEmail.php';
require '../src/Domain/User/UserPassword.php';
require '../src/Domain/User/UserRepositoryInterface.php';
require '../src/Infrastructure/Persistence/DoctrineUserRepository.php';
require '../src/Domain/User/Event/UserRegisteredEvent.php';
require '../src/Application/EventListener/UserEventListener.php';
require '../src/Application/UseCase/RegisterUserUseCase.php';
require '../src/Application/UseCase/RegisterUserRequest.php';
require '../src/Application/UserService.php';

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\SapiEmitter;
use Laminas\Diactoros\Response\JsonResponse;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Adapter\Controller\RegisterUserController;
use Application\UseCase\RegisterUserUseCase;
use Infrastructure\Event\EventDispatcher;
use Infrastructure\Persistence\DoctrineUserRepository;
use Psr\Log\NullLogger;
use Domain\User\Event\UserRegisteredEvent;
use Application\EventListener\UserEventListener;
use FastRoute\Dispatcher;
use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
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

// Crear el controlador
$registerUserController = new RegisterUserController($registerUserUseCase);

// Configurar el enrutador
$dispatcher = simpleDispatcher(function(RouteCollector $r) use ($registerUserController) {
    $r->post('/register', $registerUserController);
});

// Crear la solicitud HTTP
$request = ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

// Despachar la solicitud
$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $response = new \Laminas\Diactoros\Response\JsonResponse(['error' => 'Not Found'], 404);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response = new \Laminas\Diactoros\Response\JsonResponse(['error' => 'Method Not Allowed'], 405);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $response = $handler($request);
        break;
}

// Emitir la respuesta
$emitter = new SapiEmitter();
$emitter->emit($response);


