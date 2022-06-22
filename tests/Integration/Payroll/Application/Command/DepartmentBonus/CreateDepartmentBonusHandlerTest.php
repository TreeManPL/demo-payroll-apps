<?php

declare(strict_types=1);

namespace App\Tests\Integration\Payroll\Application\Command\DepartmentBonus;

use App\Payroll\Application\Command\DepartmentBonus\CreateDepartmentBonusCommand;
use App\Payroll\Application\Exception\DepartmentBonusAlreadyExistsException;
use App\Payroll\Domain\Repository\DepartmentBonusRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateDepartmentBonusHandlerTest extends KernelTestCase
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
    public function departmentBonusCreatedSuccessfully(): void
    {
        // given
        $departmentId = '8912b86a-af39-4c22-9416-9a4d9b994c54';
        $command = new CreateDepartmentBonusCommand(
            $departmentId,
            'percent',
            100
        );

        // when
        $this->commandBus->run($command);
        $bonus = $this->bonusRepository->findByDepartmentId($departmentId);

        // then
        $this->assertNotNull($bonus);
    }

    /**
     * @test
     */
    public function throwExceptionOnDuplicateBonus(): void
    {
        // given
        $departmentId = '235f9fd9-7ce7-4eb2-90ef-7dadc0a6ee2d';
        $command = new CreateDepartmentBonusCommand(
            $departmentId,
            'percent',
            100
        );

        // when
        $this->commandBus->run($command);
        // then
        $this->expectException(DepartmentBonusAlreadyExistsException::class);
        $this->commandBus->run($command);
    }
}
