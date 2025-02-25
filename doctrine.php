<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;

require 'vendor/autoload.php';

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    // echo "Archivo .env cargado correctamente.\n";
} catch (Exception $e) {
    echo "Error al cargar el archivo .env: " . $e->getMessage();
}

// var_dump($_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_HOST'], $_ENV['DB_DRIVER']);


function getEntityManager(): EntityManager
{
    $cache = DoctrineProvider::wrap(new ArrayAdapter());
    $config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/src/Domain'], true, null, $cache, false);
    $connectionOptions = [
        'dbname' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'host' => $_ENV['DB_HOST'],
        'driver' => $_ENV['DB_DRIVER'],
    ];

    return EntityManager::create($connectionOptions, $config);
}
