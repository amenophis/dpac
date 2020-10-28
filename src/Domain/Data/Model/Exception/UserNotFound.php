<?php

declare(strict_types=1);

namespace App\Domain\Data\Model\Exception;

class UserNotFound extends \Exception
{
    private function __construct(string $userId)
    {
        parent::__construct("Unable to find a user with id {$userId}");
    }

    public static function byId(string $id)
    {
        return new self("Unable to find a user with id {$id}");
    }

    public static function byEmail(string $email)
    {
        return new self("Unable to find a user with email {$email}");
    }
}
