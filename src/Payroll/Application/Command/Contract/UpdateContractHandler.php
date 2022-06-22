<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\Contract;

use App\Payroll\Application\Exception\ContractForUserNotExistsException;
use App\Payroll\Domain\Repository\ContractRepositoryInterface;
use App\Shared\Application\Event\EventBusInterface;
use App\Shared\Application\Event\RefreshPayrollEvent;

final class UpdateContractHandler
{
    public function __construct(private readonly ContractRepositoryInterface $repository, private readonly EventBusInterface $eventBus)
    {
    }

    public function __invoke(UpdateContractCommand $command): void
    {
        $contract = $this->repository->findByUserId($command->getUserId());
        if (null === $contract) {
            throw ContractForUserNotExistsException::create($command->getUserId());
        }

        $contract->changeSalary($command->getSalary());
        $this->repository->save($contract);

        $this->eventBus->dispatch(new RefreshPayrollEvent($command->getUserId()));
    }
}
