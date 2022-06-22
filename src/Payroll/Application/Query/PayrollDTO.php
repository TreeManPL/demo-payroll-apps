<?php

declare(strict_types=1);

namespace App\Payroll\Application\Query;

use App\Payroll\Domain\Entity\PayrollProjection;

class PayrollDTO
{
    public function __construct(
        public readonly string $employeeFirstName,
        public readonly string $employeeLastName,
        public readonly string $departmentName,
        public readonly int    $baseSalary,
        public readonly int    $bonusSalary,
        public readonly string $bonusType,
        public readonly int    $salary
    )
    {
    }

    public static function fromEntity(PayrollProjection $projection): self
    {
        return new self(
            $projection->getFirstName(),
            $projection->getLastName(),
            $projection->getDepartmentName(),
            $projection->getBaseSalary(),
            $projection->getBonusSalary(),
            $projection->getBonusType(),
            $projection->getTotalSalary()
        );
    }
}
