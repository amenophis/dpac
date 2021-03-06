<?php

declare(strict_types=1);

namespace App\Domain;

interface RandomGenerator
{
    public function generate(int $length): string;
}
