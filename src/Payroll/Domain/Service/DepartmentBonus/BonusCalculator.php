<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Service\DepartmentBonus;

use App\Payroll\Domain\Entity\Contract;

class BonusCalculator
{
    /**
     * @param BonusCalculationStrategyInterface[] $bonusCalculationStrategies
     */
    public function __construct(private readonly iterable $bonusCalculationStrategies)
    {
    }

    public function calculate(Contract $contract): int
    {
        if (null === $contract->getDepartmentBonus()) {
            return 0;
        }

        foreach ($this->bonusCalculationStrategies as $calculationStrategy) {
            if (true === $calculationStrategy->supports($contract->getDepartmentBonus()->getType())) {
                return $calculationStrategy->calculate($contract);
            }
        }

        return 0;
    }
}
