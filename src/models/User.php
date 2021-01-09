<?php

class User
{
    private $id_database;
    private $email;
    private $password;
    private $enabled;
    private $salt;
    private $created_at;
    private $name;
    private $surname;
    private $phone;
    private $image;
    private $role;
    private $last_login;

    public function __construct(int $id_database, string $email, string $password, bool $enabled, string $salt, string $created_at, string $name, string $surname, string $phone, string $image, string $role, string $last_login)
    {
        $this->id_database = $id_database;
        $this->email = $email;
        $this->password = $password;
        $this->enabled = $enabled;
        $this->salt = $salt;
        $this->created_at = $created_at;
        $this->name = $name;
        $this->surname = $surname;
        $this->phone = $phone;
        $this->image = $image;
        $this->role = $role;
        $this->last_login = $last_login;
    }

    public function getIdDatabase(): int
    {
        return $this->id_database;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): void
    {
        $this->salt = $salt;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(int $role): void
    {
        $this->role = $role;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getLastLogin(): string
    {
        return $this->last_login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }
}