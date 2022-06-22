<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Repository;

use App\Payroll\Domain\Entity\PayrollProjection;
use App\Payroll\Domain\Repository\PayrollProjectionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PayrollProjectionRepository extends ServiceEntityRepository implements PayrollProjectionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PayrollProjection::class);
    }

    public function findByUserId(string $userId): ?PayrollProjection
    {
        return $this->find($userId);
    }

    public function save(PayrollProjection $payrollProjection): void
    {
        $this->_em->persist($payrollProjection);
        $this->_em->flush();
    }

    public function findByCriteria(array $filters, string $sort, string $direction): iterable
    {
        $query = $this->createQueryBuilder('payroll')->select('')
            ->orderBy(\sprintf('payroll.%s', $sort), $direction);

        foreach ($filters as $name => $value) {
            $query->andWhere(\sprintf('payroll.%s = :%s', $name, $name))
                ->setParameter($name, $value);
        }

        return $query->getQuery()->execute();
    }
}
