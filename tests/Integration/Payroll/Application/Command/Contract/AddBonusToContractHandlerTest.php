<?php

declare(strict_types=1);

namespace App\Tests\Integration\Payroll\Application\Command\Contract;

use App\Payroll\Application\Command\Contract\AddBonusToContractCommand;
use App\Payroll\Application\Command\Contract\CreateContractCommand;
use App\Payroll\Application\Command\DepartmentBonus\CreateDepartmentBonusCommand;
use App\Payroll\Domain\Repository\ContractRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddBonusToContractHandlerTest extends KernelTestCase
{
    private CommandBusInterface $commandBus;
    private ContractRepositoryInterface $contractRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->commandBus = static::getContainer()->get(CommandBusInterface::class);
        $this->contractRepository = static::getContainer()->get(ContractRepositoryInterface::class);
    }

    /**
     * @test
     *
     */
    public function add_bonus_to_contract_successfully(): void
    {
        // given
        $userId = '2019babf-e156-418b-b47a-baae5bdd3c7e';
        $command = new CreateContractCommand(
            $userId,
            2000,
            new \DateTime()
        );

        $this->commandBus->run($command);
        $departmentId = '4e57331c-a53f-4edf-a709-e9cea46279db';
        $command = new CreateDepartmentBonusCommand(
            $departmentId,
            'percent',
            100
        );
        $this->commandBus->run($command);

        // when
        $command = new AddBonusToContractCommand(
            $userId,
            $departmentId
        );

        $this->commandBus->run($command);
        $contract = $this->contractRepository->findByUserId($userId);

        // then
        $this->assertNotNull($contract->getDepartmentBonus());
    }
}
