<?php

declare(strict_types=1);

namespace App\Domain\Data\Repository;

use App\Domain\Data\Model\Exception\UserNotFound;
use App\Domain\Data\Model\User;

interface Users
{
    public function add(User $user): void;

    /**
     * @throws UserNotFound
     */
    public function get(string $userId): User;

    /**
     * @throws UserNotFound
     */
    public function getByEmail(string $userId): User;
}
