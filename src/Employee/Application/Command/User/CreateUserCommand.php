<?php

declare(strict_types=1);

namespace App\Employee\Application\Command\User;

use App\Shared\Application\Command\CommandInterface;

final class CreateUserCommand implements CommandInterface
{
    public function __construct(private readonly string $id, private readonly string $firstName, private readonly string $lastName, private readonly ?string $departmentId)
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

    public function getDepartmentId(): ?string
    {
        return $this->departmentId;
    }
}
