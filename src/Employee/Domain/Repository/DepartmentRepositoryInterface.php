<?php

declare(strict_types=1);

namespace App\Employee\Domain\Repository;

use App\Employee\Domain\Entity\Department;

interface DepartmentRepositoryInterface
{
    public function findById(string $id): ?Department;

    public function save(Department $department): void;
}
