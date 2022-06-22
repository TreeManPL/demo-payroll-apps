<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\DepartmentBonus;

use App\Shared\Application\Command\CommandInterface;

final class CreateDepartmentBonusCommand implements CommandInterface
{
    public function __construct(private readonly string $departmentId, private readonly string $type, private readonly int $value)
    {
    }

    public function getDepartmentId(): string
    {
        return $this->departmentId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
