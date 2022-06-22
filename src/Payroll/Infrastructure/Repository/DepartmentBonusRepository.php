<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Repository;

use App\Payroll\Domain\Entity\DepartmentBonus;
use App\Payroll\Domain\Repository\DepartmentBonusRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DepartmentBonusRepository extends ServiceEntityRepository implements DepartmentBonusRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepartmentBonus::class);
    }

    public function findByDepartmentId(string $departmentId): ?DepartmentBonus
    {
        return $this->find($departmentId);
    }

    public function save(DepartmentBonus $departmentBonus): void
    {
        $this->_em->persist($departmentBonus);
        $this->_em->flush();
    }
}
