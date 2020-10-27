<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Clock;

class NativeClock implements Clock
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
