<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\DepartmentBonus;

use App\Payroll\Application\Event\DepartmentBonusWasUpdatedEvent;
use App\Payroll\Application\Exception\DepartmentBonusNotExistsException;
use App\Payroll\Domain\Entity\DepartmentBonusType;
use App\Payroll\Domain\Repository\DepartmentBonusRepositoryInterface;
use App\Shared\Application\Event\EventBusInterface;

final class UpdateDepartmentBonusHandler
{
    public function __construct(private readonly DepartmentBonusRepositoryInterface $repository, private readonly EventBusInterface $eventBus)
    {
    }

    public function __invoke(UpdateDepartmentBonusCommand $command): void
    {
        $departmentBonus = $this->repository->findByDepartmentId($command->getDepartmentId());
        if (null === $departmentBonus) {
            throw DepartmentBonusNotExistsException::create($command->getDepartmentId());
        }

        $departmentBonus->changeBonus(DepartmentBonusType::from($command->getType()), $command->getValue());
        $this->repository->save($departmentBonus);

        $this->eventBus->dispatch(new DepartmentBonusWasUpdatedEvent($command->getDepartmentId()));
    }
}
