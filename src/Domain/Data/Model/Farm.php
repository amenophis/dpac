<?php

declare(strict_types=1);

namespace App\Domain\Data\Model;

use App\Domain\Clock;
use App\Domain\IdGenerator;

class Farm
{
    private string $id;
    private string $name;
    private string $userId;
    private \DateTimeImmutable $registeredOn;

    private function __construct()
    {
    }

    public static function register(string $name, string $userId, IdGenerator $idGenerator, Clock $clock): self
    {
        $self               = new self();
        $self->id           = $idGenerator->getNew();
        $self->name         = $name;
        $self->userId       = $userId;
        $self->registeredOn = $clock->now();

        return $self;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
