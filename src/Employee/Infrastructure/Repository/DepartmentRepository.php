<?php

declare(strict_types=1);

namespace App\Employee\Infrastructure\Repository;

use App\Employee\Domain\Entity\Department;
use App\Employee\Domain\Repository\DepartmentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DepartmentRepository extends ServiceEntityRepository implements DepartmentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Department::class);
    }

    public function findById(string $id): ?Department
    {
        return $this->find($id);
    }

    public function save(Department $department): void
    {
        $this->_em->persist($department);
        $this->_em->flush();
    }
}
