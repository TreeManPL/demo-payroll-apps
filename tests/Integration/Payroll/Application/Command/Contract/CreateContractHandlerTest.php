<?php

declare(strict_types=1);

namespace App\Tests\Integration\Payroll\Application\Command\Contract;

use App\Payroll\Application\Command\Contract\CreateContractCommand;
use App\Payroll\Application\Exception\ContractForUserAlreadyExistsException;
use App\Payroll\Domain\Repository\ContractRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateContractHandlerTest extends KernelTestCase
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
    public function contractCreatedSuccessfully(): void
    {
        // given
        $userId = '43cdff23-cf6f-48e6-9505-a400a0347d54';
        $command = new CreateContractCommand(
            $userId,
            2000,
            new \DateTime()
        );

        // when
        $this->commandBus->run($command);
        $contract = $this->contractRepository->findByUserId($userId);

        // then
        $this->assertNotNull($contract);
    }

    /**
     * @test
     */
    public function throwExceptionOnDuplicateContract(): void
    {
        // given
        $userId = '26cc96fe-cf29-45b1-959c-1ba0bb609948';
        $command = new CreateContractCommand(
            $userId,
            2000,
            new \DateTime()
        );

        // when
        $this->commandBus->run($command);
        // then
        $this->expectException(ContractForUserAlreadyExistsException::class);
        $this->commandBus->run($command);
    }
}
