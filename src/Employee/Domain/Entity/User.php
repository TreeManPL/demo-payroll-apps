<?php

declare(strict_types=1);

namespace App\Employee\Domain\Entity;

class User
{
    public function __construct(private readonly string $id, private string $firstName, private string $lastName, private ?Department $department)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }
}
