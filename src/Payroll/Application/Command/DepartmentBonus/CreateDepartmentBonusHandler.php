<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\DepartmentBonus;

use App\Payroll\Application\Event\DepartmentBonusWasCreatedEvent;
use App\Payroll\Application\Exception\DepartmentBonusAlreadyExistsException;
use App\Payroll\Domain\Factory\DepartmentBonusFactory;
use App\Payroll\Domain\Repository\DepartmentBonusRepositoryInterface;
use App\Shared\Application\Event\EventBusInterface;

final class CreateDepartmentBonusHandler
{
    public function __construct(private readonly DepartmentBonusFactory $factory, private readonly DepartmentBonusRepositoryInterface $repository, private readonly EventBusInterface $eventBus)
    {
    }

    public function __invoke(CreateDepartmentBonusCommand $command)
    {
        if (null !== $this->repository->findByDepartmentId($command->getDepartmentId())) {
            throw DepartmentBonusAlreadyExistsException::create($command->getDepartmentId());
        }

        $departmentBonus = $this->factory->create($command->getDepartmentId(), $command->getType(), $command->getValue());
        $this->repository->save($departmentBonus);

        $this->eventBus->dispatch(new DepartmentBonusWasCreatedEvent($command->getDepartmentId()));
    }
}
