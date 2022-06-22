<?php

declare(strict_types=1);

namespace App\Employee\Domain\Factory;

use App\Employee\Domain\Entity\Department;
use App\Employee\Domain\Entity\User;

class UserFactory
{
    public function create(string $id, string $firstName, string $lastName, ?Department $department): User
    {
        return new User($id, $firstName, $lastName, $department);
    }
}
