<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

function getEntityManager(): EntityManager {
    // Configuración de la conexión a la base de datos
    $isDevMode = true;
    $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . '/../Domain/User'), $isDevMode);

    // Parámetros de conexión
    $connectionParams = array(
        'dbname' => getenv('DB_NAME'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'host' => getenv('DB_HOST'),
        'driver' => getenv('DB_DRIVER'), // Cambiar a 'pdo_mysql' para MySQL
    );

    // Crear el EntityManager
    return EntityManager::create($connectionParams, $config);
}
