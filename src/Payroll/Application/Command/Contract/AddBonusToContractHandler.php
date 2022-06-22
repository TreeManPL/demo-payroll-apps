<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\Contract;

use App\Payroll\Application\Exception\ContractForUserNotExistsException;
use App\Payroll\Application\Exception\DepartmentBonusNotExistsException;
use App\Payroll\Domain\Repository\ContractRepositoryInterface;
use App\Payroll\Infrastructure\Repository\DepartmentBonusRepository;
use App\Shared\Application\Event\EventBusInterface;
use App\Shared\Application\Event\RefreshPayrollEvent;

final class AddBonusToContractHandler
{
    public function __construct(private readonly ContractRepositoryInterface $contractRepository, private readonly DepartmentBonusRepository $bonusRepository, private readonly EventBusInterface $eventBus)
    {
    }

    public function __invoke(AddBonusToContractCommand $command)
    {
        $contract = $this->contractRepository->findByUserId($command->getUserId());
        if (null === $contract) {
            throw ContractForUserNotExistsException::create($command->getUserId());
        }

        $departmentBonus = $this->bonusRepository->findByDepartmentId($command->getDepartmentId());
        if (null === $departmentBonus) {
            throw DepartmentBonusNotExistsException::create($command->getDepartmentId());
        }

        $contract->setDepartmentBonus($departmentBonus);
        $this->contractRepository->save($contract);

        $this->eventBus->dispatch(new RefreshPayrollEvent($command->getUserId()));
    }
}
