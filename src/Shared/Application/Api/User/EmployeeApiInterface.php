<?php

declare(strict_types=1);

namespace App\Shared\Application\Api\User;

interface EmployeeApiInterface
{
    public function findEmployeeDetails(string $userId): ?EmployeeDetailsDTO;

    /**
     * @return EmployeeDetailsDTO[]
     */
    public function findEmployeesDetailsByDepartmentId(string $departmentId): iterable;
}
