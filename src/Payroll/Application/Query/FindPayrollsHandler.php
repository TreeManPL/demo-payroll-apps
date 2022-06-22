<?php

declare(strict_types=1);

namespace App\Payroll\Application\Query;

use App\Payroll\Domain\Entity\PayrollProjection;
use App\Payroll\Domain\Repository\PayrollProjectionRepositoryInterface;

final class FindPayrollsHandler
{
    public function __construct(private readonly PayrollProjectionRepositoryInterface $projectionRepository)
    {
    }

    /**
     * @return PayrollDTO[]
     */
    public function __invoke(FindPayrollsQuery $query): iterable
    {
        return array_map(fn (PayrollProjection $payroll) => PayrollDTO::fromEntity($payroll), $this->projectionRepository->findByCriteria($query->getFilters(), $query->getSort(), $query->getDirection()));
    }
}
