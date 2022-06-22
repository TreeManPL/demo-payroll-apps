<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Factory;

use App\Payroll\Domain\Entity\PayrollProjection;

class PayrollProjectionFactory
{
    public function create(string $userId, string $firstName, string $lastName, string $departmentName, int $baseSalary, int $bonusSalary, string $bonusType): PayrollProjection
    {
        return new PayrollProjection($userId, $firstName, $lastName, $departmentName, $baseSalary, $bonusSalary, $bonusType, $baseSalary + $bonusSalary);
    }
}
