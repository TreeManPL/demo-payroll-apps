<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Entity;

class DepartmentBonus
{
    public function __construct(private readonly string $departmentId, private DepartmentBonusType $type, private int $value)
    {
    }

    public function getDepartmentId(): string
    {
        return $this->departmentId;
    }

    public function getType(): DepartmentBonusType
    {
        return $this->type;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function changeBonus(DepartmentBonusType $type, int $value): void
    {
        $this->type = $type;
        $this->value = $value;
    }
}
