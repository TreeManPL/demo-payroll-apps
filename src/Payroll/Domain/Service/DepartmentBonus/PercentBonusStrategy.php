<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Service\DepartmentBonus;

use App\Payroll\Domain\Entity\Contract;
use App\Payroll\Domain\Entity\DepartmentBonusType;

class PercentBonusStrategy implements BonusCalculationStrategyInterface
{

    public function calculate(Contract $contract): int
    {
        return (int)(round($contract->getSalary() / 100 * $contract->getDepartmentBonus()->getValue() / 100, 2) * 100);
    }

    public function supports(DepartmentBonusType $bonusType): bool
    {
        return $bonusType === DepartmentBonusType::Percent;
    }
}
