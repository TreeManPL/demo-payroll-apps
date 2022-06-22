<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Service\DepartmentBonus;

use App\Payroll\Domain\Entity\Contract;
use App\Payroll\Domain\Entity\DepartmentBonusType;

class FixedBonusStrategy implements BonusCalculationStrategyInterface
{

    private const MaxBonusYears = 10;

    public function calculate(Contract $contract): int
    {
        $workYears = $contract->getWorkStartAt()->diff(new \DateTime(\date('Y-m-d')))->y;

        return $contract->getDepartmentBonus()->getValue() * min($workYears, self::MaxBonusYears);
    }

    public function supports(DepartmentBonusType $bonusType): bool
    {
        return $bonusType === DepartmentBonusType::Fixed;
    }
}
