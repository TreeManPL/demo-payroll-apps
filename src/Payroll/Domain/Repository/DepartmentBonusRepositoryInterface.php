<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Repository;

use App\Payroll\Domain\Entity\DepartmentBonus;

interface DepartmentBonusRepositoryInterface
{
    public function findByDepartmentId(string $departmentId): ?DepartmentBonus;

    public function save(DepartmentBonus $departmentBonus): void;
}
