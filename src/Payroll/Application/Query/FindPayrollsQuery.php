<?php

declare(strict_types=1);

namespace App\Payroll\Application\Query;

use App\Shared\Application\Query\QueryInterface;

final class FindPayrollsQuery implements QueryInterface
{
    /**
     * @param array<string, string> $filters
     */
    public function __construct(private readonly array $filters,
                                private readonly string $sort,
                                private readonly string $direction)
    {
    }

    /**
     * @return array<string, string>
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getSort(): string
    {
        return $this->sort;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }
}
