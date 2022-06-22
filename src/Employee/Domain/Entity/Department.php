<?php

declare(strict_types=1);

namespace App\Employee\Domain\Entity;

class Department
{
    public function __construct(private readonly string $id, private string $name)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
