<?php

declare(strict_types=1);

namespace App\Domain\Data\Repository;

use App\Domain\Data\Model\Supplier;

interface Suppliers
{
    public function add(Supplier $supplier): void;
}
