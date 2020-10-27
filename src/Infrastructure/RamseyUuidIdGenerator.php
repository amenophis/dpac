<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\IdGenerator;
use Ramsey\Uuid\Uuid;

class RamseyUuidIdGenerator implements IdGenerator
{
    public function getNew(): string
    {
        return Uuid::uuid4()->toString();
    }
}
