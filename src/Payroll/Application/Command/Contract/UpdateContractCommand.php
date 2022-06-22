<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\Contract;

use App\Shared\Application\Command\CommandInterface;

final class UpdateContractCommand implements CommandInterface
{
    public function __construct(private readonly string $userId, private readonly int $salary)
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getSalary(): int
    {
        return $this->salary;
    }
}
