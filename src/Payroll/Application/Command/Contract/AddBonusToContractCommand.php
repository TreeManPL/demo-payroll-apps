<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\Contract;

use App\Shared\Application\Command\CommandInterface;

final class AddBonusToContractCommand implements CommandInterface
{
    public function __construct(private readonly string $userId, private readonly string $departmentId)
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getDepartmentId(): string
    {
        return $this->departmentId;
    }
}
