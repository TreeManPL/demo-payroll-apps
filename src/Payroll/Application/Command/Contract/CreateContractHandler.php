<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\Contract;

use App\Payroll\Application\Exception\ContractForUserAlreadyExistsException;
use App\Payroll\Domain\Factory\ContractFactory;
use App\Payroll\Domain\Repository\ContractRepositoryInterface;
use App\Shared\Application\Event\EventBusInterface;
use App\Shared\Application\Event\RefreshPayrollEvent;

final class CreateContractHandler
{
    public function __construct(private readonly ContractFactory $factory, private readonly ContractRepositoryInterface $repository, private readonly EventBusInterface $eventBus)
    {
    }

    public function __invoke(CreateContractCommand $command)
    {
        if (null !== $this->repository->findByUserId($command->getUserId())) {
            throw ContractForUserAlreadyExistsException::create($command->getUserId());
        }

        $contract = $this->factory->create($command->getUserId(), $command->getSalary(), $command->getWorkStartAt());
        $this->repository->save($contract);

        $this->eventBus->dispatch(new RefreshPayrollEvent($command->getUserId()));
    }
}
