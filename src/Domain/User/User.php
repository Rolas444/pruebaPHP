<?php

namespace Domain\User;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct(UserId $id, UserName $name, UserEmail $email, UserPassword $password) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password->getHashedPassword();
        $this->createdAt =new DateTimeImmutable(); //new \DateTime();
    }

    // Getters and Setters
    public function getEmail(): UserEmail {
        return $this->email;
    }
    public function getId(): UserId {
        return $this->id;
    }
    public function getName(): UserName {
        return $this->name;
    }
}

