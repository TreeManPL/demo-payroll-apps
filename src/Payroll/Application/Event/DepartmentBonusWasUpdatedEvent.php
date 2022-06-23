<?php

declare(strict_types=1);

namespace App\Payroll\Application\Event;

use App\Shared\Application\Event\EventInterface;

class DepartmentBonusWasUpdatedEvent implements EventInterface
{
    public function __construct(public readonly string $departmentId)
    {
    }
}
