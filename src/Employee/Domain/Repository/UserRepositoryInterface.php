<?php

declare(strict_types=1);

namespace App\Employee\Domain\Repository;

use App\Employee\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function findById(string $id): ?User;

    /**
     * @return User[]
     */
    public function findUsersByDepartmentId(string $departmentId): iterable;

    public function save(User $user): void;
}
