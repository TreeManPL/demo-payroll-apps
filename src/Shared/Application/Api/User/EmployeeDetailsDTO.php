<?php

declare(strict_types=1);

namespace App\Shared\Application\Api\User;

class EmployeeDetailsDTO
{
    public function __construct(
        public readonly string $userId,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly ?string $departmentId,
        public readonly ?string $departmentName
    )
    {
    }
}
