<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Entity;

enum DepartmentBonusType: string
{
    case Percent = 'percent';
    case Fixed = 'fixed';
}
