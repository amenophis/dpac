<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\ORM\Repository;

use App\Domain\Data\Model\Exception\UserNotFound;
use App\Domain\Data\Model\User;
use App\Domain\Data\Repository\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template TEntityClass of object
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements Users
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $user): void
    {
        $this->_em->persist($user);
    }

    public function get(string $userId): User
    {
        /** @var ?User $user */
        $user = $this->find($userId);
        if (null === $user) {
            throw new UserNotFound($userId);
        }

        return $user;
    }
}
