<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\ORM\Repository;

use App\Domain\Data\Model\Supplier;
use App\Domain\Data\Repository\Suppliers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template TEntityClass of object
 * @extends ServiceEntityRepository<Supplier>
 */
class SupplierRepository extends ServiceEntityRepository implements Suppliers
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supplier::class);
    }

    public function add(Supplier $supplier): void
    {
        $this->_em->persist($supplier);
    }
}
