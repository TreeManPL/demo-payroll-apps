<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Factory;

use App\Payroll\Domain\Entity\DepartmentBonus;
use App\Payroll\Domain\Entity\DepartmentBonusType;

class DepartmentBonusFactory
{
    public function create(string $departmentId, string $type, int $value): DepartmentBonus
    {
        return new DepartmentBonus($departmentId, DepartmentBonusType::from($type), $value);
    }
}
