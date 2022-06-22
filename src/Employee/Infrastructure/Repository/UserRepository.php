<?php

declare(strict_types=1);

namespace App\Employee\Infrastructure\Repository;

use App\Employee\Domain\Entity\User;
use App\Employee\Domain\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findById(string $id): ?User
    {
        return $this->find($id);
    }

    public function findUsersByDepartmentId(string $departmentId): iterable
    {
        return $this->findBy(['department' => $departmentId]);
    }

    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
