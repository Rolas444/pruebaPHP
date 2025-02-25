<?php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

exec('php vendor/bin/doctrine-migrations migrate --no-interaction');

function getEntityManager(): EntityManager
{   
    $domainPath = realpath(__DIR__ . '/src/Domain');
    if ($domainPath === false) {
        throw new \RuntimeException('Invalid path to domain directory');
    }

    $cache = DoctrineProvider::wrap(new ArrayAdapter());
    $config = Setup::createAnnotationMetadataConfiguration([$domainPath], true, null, $cache, false);
    $connectionOptions = [
        'dbname' => $_ENV['TEST_DB_NAME'],
        'user' => $_ENV['TEST_DB_USER'],
        'password' => $_ENV['TEST_DB_PASSWORD'],
        'host' => $_ENV['TEST_DB_HOST'],
        'driver' => $_ENV['TEST_DB_DRIVER'],
    ];

    return EntityManager::create($connectionOptions, $config);
}
