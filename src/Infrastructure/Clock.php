<?php

declare(strict_types=1);

namespace App\Infrastructure;

class Clock implements \App\Domain\Clock
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
