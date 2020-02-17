<?php

namespace App\User;

use DateTime;

class User
{
    private $id;

    private $name;

    private $emailAddress;

    private $password;

    private $createdAt;

    private $updatedAt;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): User
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): User
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): User
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
