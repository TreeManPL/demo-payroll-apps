<?php

declare(strict_types=1);

namespace App\Employee\Application\Command\Deprtment;

use App\Employee\Application\Exception\DepartmentAlreadyExistsException;
use App\Employee\Domain\Factory\DepartmentFactory;
use App\Employee\Domain\Repository\DepartmentRepositoryInterface;

final class CreateDepartmentHandler
{
    public function __construct(private readonly DepartmentFactory $factory, private readonly DepartmentRepositoryInterface $repository)
    {
    }

    public function __invoke(CreateDepartmentCommand $command): void
    {
        if (null !== $this->repository->findById($command->getId())) {
            throw DepartmentAlreadyExistsException::create($command->getId());
        }
        $department = $this->factory->create($command->getId(), $command->getName());
        $this->repository->save($department);
    }
}
