<?php

declare(strict_types=1);

namespace App\Tests\Unit\Payroll\Domain\Service\DepartmentBonus;

use App\Payroll\Domain\Entity\Contract;
use App\Payroll\Domain\Entity\DepartmentBonus;
use App\Payroll\Domain\Entity\DepartmentBonusType;
use App\Payroll\Domain\Service\DepartmentBonus\FixedBonusStrategy;
use PHPUnit\Framework\TestCase;

class FixedBonusStrategyTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCalculateSucessfullyBefoureFirstYearOfWork()
    {
        // given
        $departmentBonus = new DepartmentBonus('2cb509e2-a0e6-4d87-a44a-36f27b4ab13b', DepartmentBonusType::Fixed, 3000);
        $contract = new Contract('59556cc2-2ced-4d56-bcc6-28b1581cf691', 5000, new \DateTime('-11 month'), $departmentBonus);

        $bonusCalculator = new FixedBonusStrategy();

        // when & then
        $this->assertEquals(0, $bonusCalculator->calculate($contract));
    }

    /**
     * @test
     */
    public function shouldCalculateSucessfullyAfterFirstYearOfWork()
    {
        $departmentBonus = new DepartmentBonus('2cb509e2-a0e6-4d87-a44a-36f27b4ab13b', DepartmentBonusType::Fixed, 3000);
        $contract = new Contract('59556cc2-2ced-4d56-bcc6-28b1581cf691', 5000, new \DateTime('-16 month'), $departmentBonus);

        $bonusCalculator = new FixedBonusStrategy();

        $this->assertEquals(3000, $bonusCalculator->calculate($contract));
    }

    /**
     * @test
     */
    public function shouldCalculateSucessfullyAfterFewYearsFirstYearOfWork()
    {
        $departmentBonus = new DepartmentBonus('2cb509e2-a0e6-4d87-a44a-36f27b4ab13b', DepartmentBonusType::Fixed, 3000);
        $contract = new Contract('59556cc2-2ced-4d56-bcc6-28b1581cf691', 5000, new \DateTime('-25 month'), $departmentBonus);

        $bonusCalculator = new FixedBonusStrategy();

        $this->assertEquals(6000, $bonusCalculator->calculate($contract));
    }

    /**
     * @test
     */
    public function shouldCalculateSucessfullyOverTenYears()
    {
        $departmentBonus = new DepartmentBonus('2cb509e2-a0e6-4d87-a44a-36f27b4ab13b', DepartmentBonusType::Fixed, 3000);
        $contract = new Contract('59556cc2-2ced-4d56-bcc6-28b1581cf691', 5000, new \DateTime('-20 year'), $departmentBonus);

        $bonusCalculator = new FixedBonusStrategy();

        $this->assertEquals(30000, $bonusCalculator->calculate($contract));
    }
}
