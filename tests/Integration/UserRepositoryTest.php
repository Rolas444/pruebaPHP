<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\SchemaTool;
use Domain\User\User;
use Domain\User\UserId;
use Domain\User\UserName;
use Domain\User\UserEmail;
use Domain\User\UserPassword;
use Infrastructure\Persistence\Doctrine\UserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Infrastructure\Persistence\DoctrineUserRepository;

class UserRepositoryTest extends TestCase
{
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = getEntityManager();

        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($metadata);
    }

    protected function tearDown(): void
    {
        // Eliminar el esquema de la base de datos después de las pruebas
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);

        $this->entityManager->close();
        //$this->entityManager = null; 
    }

    public function testUserRepositoryCanSaveAndRetrieveUser(): void
    {
        $userRepository = new DoctrineUserRepository($this->entityManager);
        $id = new UserId('545');
        $name = new UserName('nametest');
        $email = new UserEmail('test@example.com');
        $password = new UserPassword('passwordtest12333.YU');
        $user = new User($id, $name, $email, $password);

        // Guardar el usuario en la base de datos
        $userRepository->save($user);

        // Recuperar el usuario de la base de datos
        $retrievedUser = $userRepository->findByEmail($email);

        $this->assertNotNull($retrievedUser);
        $this->assertEquals('test@example.com', $retrievedUser->getEmail());
    }
}