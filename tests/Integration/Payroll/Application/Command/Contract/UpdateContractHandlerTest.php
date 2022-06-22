<?php

declare(strict_types=1);

namespace App\Tests\Integration\Payroll\Application\Command\Contract;

use App\Payroll\Application\Command\Contract\CreateContractCommand;
use App\Payroll\Application\Command\Contract\UpdateContractCommand;
use App\Payroll\Application\Exception\ContractForUserNotExistsException;
use App\Payroll\Domain\Repository\ContractRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UpdateContractHandlerTest extends KernelTestCase
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
     */
    public function contractUpdatedSuccessfully(): void
    {
        // given
        $userId = '2c1de971-2a53-4bf4-b731-b7bae232f55f';
        $salary = 2000;
        $updatedSalary = 3000;

        $createCommand = new CreateContractCommand(
            $userId,
            $salary,
            new \DateTime()
        );
        $this->commandBus->run($createCommand);

        // when
        $command = new UpdateContractCommand(
            $userId,
            $updatedSalary
        );

        $this->commandBus->run($command);

        // then
        $contract = $this->contractRepository->findByUserId($userId);

        $this->assertEquals($updatedSalary, $contract->getSalary());
    }

    /**
     * @test
     */
    public function throwExceptionOnNoContract(): void
    {
        $userId = '435028e3-940a-4da6-a326-04012dd40295';

        $command = new UpdateContractCommand(
            $userId,
            1000
        );

        $this->expectException(ContractForUserNotExistsException::class);
        $this->commandBus->run($command);
    }
}
