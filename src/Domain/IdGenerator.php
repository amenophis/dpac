<?php

declare(strict_types=1);

namespace App\Domain;

interface IdGenerator
{
    public function getNew(): string;
}
