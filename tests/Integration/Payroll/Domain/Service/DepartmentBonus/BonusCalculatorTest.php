<?php

declare(strict_types=1);

namespace App\Tests\Integration\Payroll\Domain\Service\DepartmentBonus;

use App\Payroll\Application\Command\DepartmentBonus\CreateDepartmentBonusCommand;
use App\Payroll\Application\Exception\DepartmentBonusAlreadyExistsException;
use App\Payroll\Domain\Entity\Contract;
use App\Payroll\Domain\Entity\DepartmentBonus;
use App\Payroll\Domain\Entity\DepartmentBonusType;
use App\Payroll\Domain\Repository\DepartmentBonusRepositoryInterface;
use App\Payroll\Domain\Service\DepartmentBonus\BonusCalculator;
use App\Payroll\Domain\Service\DepartmentBonus\PercentBonusStrategy;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BonusCalculatorTest extends KernelTestCase
{
    private BonusCalculator $bonusCalculator;

    public function setUp(): void
    {
        parent::setUp();

        $this->bonusCalculator = static::getContainer()->get(BonusCalculator::class);
    }

    /**
     * @test
     *
     */
    public function should_calculate_percent_bonus_successfully(): void
    {
        // given
        $departmentBonus = new DepartmentBonus('2cb509e2-a0e6-4d87-a44a-36f27b4ab13b', DepartmentBonusType::Percent, 13);
        $contract = new Contract('59556cc2-2ced-4d56-bcc6-28b1581cf691', 51200, new \DateTime('now'), $departmentBonus);

        // when
        $value = $this->bonusCalculator->calculate($contract);

        // then
        $this->assertEquals(6656, $value);
    }

    /**
     * @test
     *
     */
    public function should_calculate_fixed_bonus_successfully(): void
    {
        // given
        $departmentBonus = new DepartmentBonus('2cb509e2-a0e6-4d87-a44a-36f27b4ab13b', DepartmentBonusType::Fixed, 3000);
        $contract = new Contract('59556cc2-2ced-4d56-bcc6-28b1581cf691', 5000, new \DateTime('-25 month'), $departmentBonus);

        // when
        $value = $this->bonusCalculator->calculate($contract);

        // then
        $this->assertEquals(6000, $value);
    }
}
