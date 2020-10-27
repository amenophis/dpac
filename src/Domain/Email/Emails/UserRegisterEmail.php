<?php

declare(strict_types=1);

namespace App\Domain\Email\Emails;

use App\Domain\Data\Model\User;
use App\Domain\Email\Address;
use App\Domain\Email\Email;

class UserRegisterEmail extends Email
{
    public function __construct(User $user)
    {
        parent::__construct(
            [new Address($user->getEmail(), $user->getFullname())],
            'DPAC - Confirm your email',
            'emails/user/confirm_email.html.twig',
            [
                'user' => $user,
            ]
        );
    }
}
