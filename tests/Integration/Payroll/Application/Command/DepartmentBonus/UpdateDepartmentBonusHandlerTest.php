<?php

declare(strict_types=1);

namespace App\Tests\Integration\Payroll\Application\Command\DepartmentBonus;

use App\Payroll\Application\Command\DepartmentBonus\CreateDepartmentBonusCommand;
use App\Payroll\Application\Command\DepartmentBonus\UpdateDepartmentBonusCommand;
use App\Payroll\Application\Exception\DepartmentBonusNotExistsException;
use App\Payroll\Domain\Repository\DepartmentBonusRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UpdateDepartmentBonusHandlerTest extends KernelTestCase
{
    private CommandBusInterface $commandBus;
    private DepartmentBonusRepositoryInterface $bonusRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->commandBus = static::getContainer()->get(CommandBusInterface::class);
        $this->bonusRepository = static::getContainer()->get(DepartmentBonusRepositoryInterface::class);
    }

    /**
     * @test
     */
    public function department_bonus_updated_successfully(): void
    {
        // given
        $departmentId = 'a606ca9e-9c31-45d5-9db1-07813f419100';
        $updatedType = 'fixed';
        $updateValue = 10000;

        $command = new CreateDepartmentBonusCommand(
            $departmentId,
            'percent',
            100
        );

        $this->commandBus->run($command);

        // when
        $command = new UpdateDepartmentBonusCommand(
            $departmentId,
            $updatedType,
            $updateValue
        );

        $this->commandBus->run($command);

        // then
        $bonus = $this->bonusRepository->findByDepartmentId($departmentId);

        $this->assertEquals($updatedType, $bonus->getType()->value);
        $this->assertEquals($updateValue, $bonus->getValue());
    }

    /**
     * @test
     */
    public function throw_exception_on_no_bonus(): void
    {
        $departmentId = 'b884f2ab-cc76-43f9-b995-05d7a987bb69';

        $command = new UpdateDepartmentBonusCommand(
            $departmentId,
            'percent',
            100
        );

        $this->expectException(DepartmentBonusNotExistsException::class);
        $this->commandBus->run($command);
    }
}
