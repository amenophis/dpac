<?php

declare(strict_types=1);

namespace App\Domain\UseCase\AUserWantsToActivateHisAccount;

use App\Domain\Clock;
use App\Domain\Data\Model\Exception\InvalidUserActivationToken;
use App\Domain\Data\Model\Exception\UserNotFound;
use App\Domain\Data\Repository\Users;
use App\Domain\Notifier;
use App\Domain\PasswordEncoder;
use App\Domain\RandomGenerator;
use App\Domain\UseCase\UseCaseHandler;

class Handler implements UseCaseHandler
{
    private Users $users;
    private RandomGenerator $randomGenerator;
    private Clock $clock;
    private PasswordEncoder $passwordEncoder;
    private Notifier $notifier;

    public function __construct(Users $user, RandomGenerator $randomGenerator, Clock $clock, PasswordEncoder $passwordEncoder, Notifier $notifier)
    {
        $this->users           = $user;
        $this->randomGenerator = $randomGenerator;
        $this->clock           = $clock;
        $this->passwordEncoder = $passwordEncoder;
        $this->notifier        = $notifier;
    }

    /**
     * @throws UserNotFound
     * @throws InvalidUserActivationToken
     */
    public function __invoke(Input $input): void
    {
        $user = $this->users->get($input->getUserId());
        $user->activate($input->getActivationToken(), $input->getPlainPassword(), $this->clock, $this->passwordEncoder);
        $this->notifier->notify(Notifier::TYPE_SUCCESS, 'Your user is activated !');
    }
}
