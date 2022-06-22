<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Factory;

use App\Payroll\Domain\Entity\Contract;

class ContractFactory
{
    public function create(string $userId, int $salary, \DateTime $workStartAt): Contract
    {
        return new Contract($userId, $salary, $workStartAt, null);
    }
}
