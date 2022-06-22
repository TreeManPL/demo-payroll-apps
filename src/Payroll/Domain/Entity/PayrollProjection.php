<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Entity;

class PayrollProjection
{
    public function __construct(
        private readonly string $userId,
        private string $firstName,
        private string $lastName,
        private string $departmentName,
        private int $baseSalary,
        private int $bonusSalary,
        private string $bonusType,
        private int $totalSalary,
    )
    {
    }

    public function changeProjectionSallary(int $baseSalary, int $bonusSalary, string $bonusType)
    {
        $this->baseSalary = $baseSalary;
        $this->bonusSalary = $bonusSalary;
        $this->bonusType = $bonusType;
        $this->totalSalary = $bonusSalary + $baseSalary;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getDepartmentName(): string
    {
        return $this->departmentName;
    }

    public function getBaseSalary(): int
    {
        return $this->baseSalary;
    }

    public function getBonusSalary(): int
    {
        return $this->bonusSalary;
    }

    public function getBonusType(): string
    {
        return $this->bonusType;
    }

    public function getTotalSalary(): int
    {
        return $this->totalSalary;
    }
}
