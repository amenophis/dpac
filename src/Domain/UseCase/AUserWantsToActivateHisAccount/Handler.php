<?php

declare(strict_types=1);

namespace App\Domain\UseCase\AUserWantsToActivateHisAccount;

use App\Domain\Clock;
use App\Domain\Data\Model\Exception\InvalidUserActivationToken;
use App\Domain\Data\Model\Exception\UserNotFound;
use App\Domain\Data\Repository\Users;
use App\Domain\Email\Mailer;
use App\Domain\PasswordEncoder;
use App\Domain\RandomGenerator;
use App\Domain\UseCase\UseCaseHandler;

class Handler implements UseCaseHandler
{
    private Users $users;
    private RandomGenerator $randomGenerator;
    private Clock $clock;
    private Mailer $mailer;
    private PasswordEncoder $passwordEncoder;

    public function __construct(Users $user, RandomGenerator $randomGenerator, Clock $clock, PasswordEncoder $passwordEncoder)
    {
        $this->users           = $user;
        $this->randomGenerator = $randomGenerator;
        $this->clock           = $clock;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @throws UserNotFound
     * @throws InvalidUserActivationToken
     */
    public function __invoke(Input $input): void
    {
        $user = $this->users->get($input->getUserId());
        $user->activate($input->getActivationToken(), $input->getPlainPassword(), $this->clock, $this->passwordEncoder);
    }
}
