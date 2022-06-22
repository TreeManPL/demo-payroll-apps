<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Repository;

use App\Payroll\Domain\Entity\Contract;

interface ContractRepositoryInterface
{
    public function findByUserId(string $userId): ?Contract;

    public function save(Contract $contract): void;
}
