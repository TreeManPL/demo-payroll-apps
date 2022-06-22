<?php

declare(strict_types=1);

namespace App\Employee\Application\Command\Deprtment;

use App\Shared\Application\Command\CommandInterface;

final class CreateDepartmentCommand implements CommandInterface
{
    public function __construct(private readonly string $id, private readonly string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
