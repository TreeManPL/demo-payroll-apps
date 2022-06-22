<?php

declare(strict_types=1);

namespace App\Tests\Unit\Payroll\Domain\Service\DepartmentBonus;

use App\Payroll\Domain\Entity\Contract;
use App\Payroll\Domain\Entity\DepartmentBonus;
use App\Payroll\Domain\Entity\DepartmentBonusType;
use App\Payroll\Domain\Service\DepartmentBonus\PercentBonusStrategy;
use PHPUnit\Framework\TestCase;

class PercentBonusStrategyTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCalculateBonusSucessfully(): void
    {
        $departmentBonus = new DepartmentBonus('2cb509e2-a0e6-4d87-a44a-36f27b4ab13b', DepartmentBonusType::Percent, 13);
        $contract = new Contract('59556cc2-2ced-4d56-bcc6-28b1581cf691', 51200, new \DateTime('now'), $departmentBonus);

        $bonusCalculator = new PercentBonusStrategy();

        $this->assertEquals(6656, $bonusCalculator->calculate($contract));
    }

    /**
     * @test
     */
    public function shouldCalculateBonusForLowSalarySucessfully(): void
    {
        $departmentBonus = new DepartmentBonus('2cb509e2-a0e6-4d87-a44a-36f27b4ab13b', DepartmentBonusType::Percent, 13);
        $contract = new Contract('59556cc2-2ced-4d56-bcc6-28b1581cf691', 50, new \DateTime('now'), $departmentBonus);

        $bonusCalculator = new PercentBonusStrategy();

        $this->assertEquals(7, $bonusCalculator->calculate($contract));
    }
}
