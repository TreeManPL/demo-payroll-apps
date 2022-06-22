<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Repository;

use App\Payroll\Domain\Entity\PayrollProjection;

interface PayrollProjectionRepositoryInterface
{
    public function findByUserId(string $userId): ?PayrollProjection;

    public function save(PayrollProjection $payrollProjection): void;

    /**
     * @return PayrollProjection[]
     */
    public function findByCriteria(array $filters, string $sort, string $direction): iterable;
}
