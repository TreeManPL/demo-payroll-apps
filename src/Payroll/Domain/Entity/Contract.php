<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Entity;

class Contract
{
    public function __construct(private readonly string $userId, private int $salary, private readonly \DateTime $workStartAt, private ?DepartmentBonus $departmentBonus)
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getSalary(): int
    {
        return $this->salary;
    }

    public function getWorkStartAt(): \DateTime
    {
        return $this->workStartAt;
    }

    public function changeSalary(int $salary): void
    {
        $this->salary = $salary;
    }

    public function setDepartmentBonus(?DepartmentBonus $departmentBonus): void
    {
        $this->departmentBonus = $departmentBonus;
    }

    public function getDepartmentBonus(): ?DepartmentBonus
    {
        return $this->departmentBonus;
    }
}
