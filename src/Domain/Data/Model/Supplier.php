<?php

declare(strict_types=1);

namespace App\Domain\Data\Model;

use App\Domain\Clock;
use App\Domain\IdGenerator;

class Supplier
{
    private string $id;
    private string $name;
    private string $email;
    private \DateTimeImmutable $registeredOn;

    private function __construct()
    {
    }

    public static function register(string $name, string $email, IdGenerator $idGenerator, Clock $clock): self
    {
        $self               = new self();
        $self->id           = $idGenerator->getNew();
        $self->name         = $name;
        $self->email        = $email;
        $self->registeredOn = $clock->now();

        return $self;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
