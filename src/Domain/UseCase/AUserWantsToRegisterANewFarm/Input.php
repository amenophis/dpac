<?php

declare(strict_types=1);

namespace App\Domain\UseCase\AUserWantsToRegisterANewFarm;

class Input
{
    private string $userFirstname;
    private string $userLastname;
    private string $userEmail;
    private string $farmName;

    public function __construct(string $userFirstname, string $userLastname, string $userEmail, string $farmName)
    {
        $this->userFirstname = $userFirstname;
        $this->userLastname  = $userLastname;
        $this->userEmail     = $userEmail;
        $this->farmName      = $farmName;
    }

    public function getUserFirstname(): string
    {
        return $this->userFirstname;
    }

    public function getUserLastname(): string
    {
        return $this->userLastname;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function getFarmName(): string
    {
        return $this->farmName;
    }
}
