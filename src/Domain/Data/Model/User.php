<?php

declare(strict_types=1);

namespace App\Domain\Data\Model;

use App\Domain\Clock;
use App\Domain\Data\Model\Exception\InvalidUserActivationToken;
use App\Domain\IdGenerator;
use App\Domain\PasswordEncoder;
use App\Domain\RandomGenerator;

class User
{
    private string $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private ?string $password = null;
    private \DateTimeImmutable $registeredOn;
    private ?string $activationToken         = null;
    private ?\DateTimeImmutable $activatedOn = null;

    private function __construct()
    {
    }

    public static function register(string $firstname, string $lastname, string $email, IdGenerator $idGenerator, Clock $clock, RandomGenerator $randomGenerator): self
    {
        $self                  = new self();
        $self->id              = $idGenerator->getNew();
        $self->lastname        = $lastname;
        $self->firstname       = $firstname;
        $self->email           = $email;
        $self->registeredOn    = $clock->now();
        $self->activationToken = $randomGenerator->generate(64);

        return $self;
    }

    /**
     * @throws InvalidUserActivationToken
     */
    public function activate(string $activationToken, string $plainPassword, Clock $clock, PasswordEncoder $passwordEncoder): void
    {
        if ($this->activationToken !== $activationToken) {
            throw new InvalidUserActivationToken($this);
        }

        $this->activationToken = null;
        $this->activatedOn     = $clock->now();
        $this->password        = $passwordEncoder->encode($this, $plainPassword);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getFullname(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRegisteredOn(): \DateTimeImmutable
    {
        return $this->registeredOn;
    }

    public function getActivationToken(): ?string
    {
        return $this->activationToken;
    }

    public function getActivatedOn(): ?\DateTimeImmutable
    {
        return $this->activatedOn;
    }
}
