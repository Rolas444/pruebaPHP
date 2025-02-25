<?php

namespace Application\DTO;

class UserResponseDTO {
    public string $id;
    public string $name;
    public string $email;
    public string $createdAt;

    public function __construct(string $id, string $name, string $email, string $createdAt) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->createdAt,
        ];
    }
}