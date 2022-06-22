<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Service\DepartmentBonus;

use App\Payroll\Domain\Entity\Contract;
use App\Payroll\Domain\Entity\DepartmentBonusType;

interface BonusCalculationStrategyInterface
{
    public function calculate(Contract $contract): int;

    public function supports(DepartmentBonusType $bonusType): bool;
}
