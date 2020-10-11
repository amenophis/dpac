<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Ramsey\Uuid\Uuid;

class IdGenerator implements \App\Domain\IdGenerator
{
    public function getNew(): string
    {
        return Uuid::uuid4()->toString();
    }
}
