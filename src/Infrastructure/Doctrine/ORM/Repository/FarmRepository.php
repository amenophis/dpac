<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\ORM\Repository;

use App\Domain\Data\Model\Farm;
use App\Domain\Data\Repository\Farms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template TEntityClass of object
 * @extends ServiceEntityRepository<Farm>
 */
class FarmRepository extends ServiceEntityRepository implements Farms
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Farm::class);
    }

    public function add(Farm $farm): void
    {
        $this->_em->persist($farm);
    }
}
