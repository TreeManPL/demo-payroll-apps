<?php

declare(strict_types=1);

namespace App\Payroll\Application\Subscriber;

use App\Payroll\Application\Command\Contract\AddBonusToContractCommand;
use App\Payroll\Application\Event\DepartmentBonusWasCreatedEvent;
use App\Shared\Application\Api\User\EmployeeApiInterface;
use App\Shared\Application\Command\CommandBusInterface;

class DepartmentBonusWasCreatedSubscriber
{
    public function __construct(private readonly EmployeeApiInterface $employeeApi, private readonly CommandBusInterface $commandBus)
    {
    }

    public function __invoke(DepartmentBonusWasCreatedEvent $event)
    {
        $users = $this->employeeApi->findEmployeesDetailsByDepartmentId($event->departmentId);

        foreach ($users as $user) {
            $this->commandBus->run(
                new AddBonusToContractCommand($user->userId, $user->departmentId)
            );
        }
    }
}
