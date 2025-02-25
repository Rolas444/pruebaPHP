<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/vendor/autoload.php';

// Cargar las variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Incluir la configuración de Doctrine
require_once __DIR__ . '/phpunit-bootstrap.php';

// Obtener el EntityManager
$entityManager = getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);