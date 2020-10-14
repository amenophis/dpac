<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Data\Model\User;

interface PasswordEncoder
{
    public function encode(User $user, string $password): string;
}
