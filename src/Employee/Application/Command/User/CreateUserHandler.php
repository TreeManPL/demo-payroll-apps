<?php

declare(strict_types=1);

namespace App\Employee\Application\Command\User;

use App\Employee\Application\Exception\DepartmentNotExistsException;
use App\Employee\Application\Exception\UserAlreadyExistsException;
use App\Employee\Domain\Factory\UserFactory;
use App\Employee\Domain\Repository\DepartmentRepositoryInterface;
use App\Employee\Domain\Repository\UserRepositoryInterface;

final class CreateUserHandler
{
    public function __construct(private readonly UserFactory $factory, private readonly DepartmentRepositoryInterface $departmentRepository, private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(CreateUserCommand $command)
    {
        if (null !== $this->userRepository->findById($command->getId())) {
            throw UserAlreadyExistsException::create($command->getId());
        }

        $department = match ($command->getDepartmentId()) {
            null => null,
            default => $this->departmentRepository->findById($command->getDepartmentId())
        };

        if (null === $department && null !== $command->getDepartmentId()) {
            throw DepartmentNotExistsException::create($command->getDepartmentId());
        }

        $user = $this->factory->create(
          $command->getId(),
          $command->getFirstName(),
          $command->getLastName(),
          $department
        );

        $this->userRepository->save($user);
    }
}
