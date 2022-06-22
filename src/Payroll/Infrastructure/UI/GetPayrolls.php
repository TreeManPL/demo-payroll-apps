<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\UI;

use App\Payroll\Application\Query\FindPayrollsQuery;
use App\Payroll\Application\Query\PayrollDTO;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payrolls', methods: ['GET'])]
class GetPayrolls
{
    private const DEFAULT_SORT = 'firstName';
    private const DEFAULT_SORT_ORDER = 'asc';
    private static array $allowFilter = [
        'firstName', 'lastName', 'departmentName',
    ];
    private static array $allowSort = [
        'firstName',
        'lastName',
        'departmentName',
        'baseSalary',
        'bonusSalary',
        'bonusType',
        'salary',
    ];
    private static array $allowSortDirection = ['asc', 'desc'];

    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $sort = self::DEFAULT_SORT;
        $dir = self::DEFAULT_SORT_ORDER;
        $filters = [];

        $data = $request->query->all();

        if (\in_array($data['sort'] ?? '', self::$allowSort)) {
            $sort = $data['sort'];
        }

        if (\in_array($data['dir'] ?? '', self::$allowSortDirection)) {
            $dir = $data['dir'];
        }

        foreach ($data['filter'] ?? [] as $name => $value) {
            if (\in_array($name, self::$allowFilter)) {
                $filters[$name] = $value;
            }
        }
        $query = new FindPayrollsQuery(
            $filters,
            $sort,
            $dir
        );

        $response = [];
        /** @var PayrollDTO $result */
        foreach ($this->queryBus->run($query) as $result) {
            $response[] = [
                'firstName' => $result->employeeFirstName,
                'lastName' => $result->employeeLastName,
                'departmentName' => $result->departmentName,
                'baseSalary' => (float) $result->baseSalary / 100,
                'bonusSalary' => (float) $result->bonusSalary / 100,
                'bonusType' => $result->bonusType,
                'salary' => (float) $result->salary / 100,
            ];
        }

        return new JsonResponse($response);
    }
}
