<?php

declare(strict_types=1);

namespace App\Employee\Domain\Factory;

use App\Employee\Domain\Entity\Department;

class DepartmentFactory
{
    public function create(string $id, string $name): Department
    {
        return new Department($id, $name);
    }
}
