<?php

declare(strict_types=1);

namespace App\Domain\Data\Repository;

use App\Domain\Data\Model\Farm;

interface Farms
{
    public function add(Farm $farm): void;
}
