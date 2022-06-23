<?php

declare(strict_types=1);

namespace App\Payroll\Application\Subscriber;

use App\Payroll\Application\Event\DepartmentBonusWasUpdatedEvent;
use App\Shared\Application\Api\User\EmployeeApiInterface;
use App\Shared\Application\Event\EventBusInterface;
use App\Shared\Application\Event\RefreshPayrollEvent;

class DepartmentBonusWasUpdatedSubscriber
{
    public function __construct(private readonly EmployeeApiInterface $employeeApi, private readonly EventBusInterface $eventBus)
    {
    }

    public function __invoke(DepartmentBonusWasUpdatedEvent $event): void
    {
        $users = $this->employeeApi->findEmployeesDetailsByDepartmentId($event->departmentId);

        foreach ($users as $user) {
            $this->eventBus->dispatch(new RefreshPayrollEvent($user->userId));
        }
    }
}
