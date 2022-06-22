<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\Contract;

use App\Shared\Application\Command\CommandInterface;

final class CreateContractCommand implements CommandInterface
{
    public function __construct(private readonly string $userId, private readonly int $salary, private readonly \DateTime $workStartAt)
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

    public function getWorkStartAt(): \DateTime
    {
        return $this->workStartAt;
    }
}
