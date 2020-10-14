<?php

declare(strict_types=1);

namespace App\Domain\Data\Model\Exception;

class UserNotFound extends \Exception
{
    public function __construct(string $userId)
    {
        parent::__construct("Unable to find a user with id {$userId}");
    }
}
