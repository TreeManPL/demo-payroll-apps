<?php

declare(strict_types=1);

namespace App\Employee\Application\Api;

use App\Employee\Domain\Entity\User;
use App\Employee\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Api\User\EmployeeApiInterface;
use App\Shared\Application\Api\User\EmployeeDetailsDTO;

final class EmployeeApi implements EmployeeApiInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function findEmployeeDetails(string $userId): ?EmployeeDetailsDTO
    {
        $user = $this->userRepository->findById($userId);

        if(null === $user) {
            return null;
        }

        return $this->convertUserToEmployeeDetailsDTO($user);
    }

    public function findEmployeesDetailsByDepartmentId(string $departmentId): iterable
    {
        $users = $this->userRepository->findUsersByDepartmentId($departmentId);

        foreach ($users as $user) {
            yield $this->convertUserToEmployeeDetailsDTO($user);
        }
    }

    private function convertUserToEmployeeDetailsDTO(User $user): EmployeeDetailsDTO
    {
        return new EmployeeDetailsDTO(
            $user->getId(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getDepartment()?->getId(),
            $user->getDepartment()?->getName(),
        );
    }
}
