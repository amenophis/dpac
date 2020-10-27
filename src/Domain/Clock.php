<?php

declare(strict_types=1);

namespace App\Domain;

interface Clock
{
    public function now(): \DateTimeImmutable;
}
