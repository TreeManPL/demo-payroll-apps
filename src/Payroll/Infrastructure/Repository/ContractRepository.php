<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Repository;

use App\Payroll\Domain\Entity\Contract;
use App\Payroll\Domain\Repository\ContractRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContractRepository extends ServiceEntityRepository implements ContractRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contract::class);
    }

    public function findByUserId(string $userId): ?Contract
    {

        return $this->find($userId);
    }

    public function save(Contract $contract): void
    {
        $this->_em->persist($contract);
        $this->_em->flush();
    }

    public function findAllContracts(): iterable
    {
        return $this->findAll();
    }
}
