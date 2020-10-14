<?php

declare(strict_types=1);

namespace App\Domain\UseCase\AUserWantsToRegisterANewFarm;

use App\Domain\Clock;
use App\Domain\Data\Model\Farm;
use App\Domain\Data\Model\User;
use App\Domain\Data\Repository\Farms;
use App\Domain\Data\Repository\Users;
use App\Domain\Email\Emails\UserRegisterEmail;
use App\Domain\Email\Mailer;
use App\Domain\IdGenerator;
use App\Domain\RandomGenerator;
use App\Domain\UseCase\UseCaseHandler;

class Handler implements UseCaseHandler
{
    private Farms $farms;
    private Users $users;
    private IdGenerator $idGenerator;
    private Clock $clock;
    private RandomGenerator $randomGenerator;
    private Mailer $mailer;

    public function __construct(Farms $farms, Users $user, IdGenerator $idGenerator, Clock $clock, RandomGenerator $randomGenerator, Mailer $mailer)
    {
        $this->farms           = $farms;
        $this->users           = $user;
        $this->idGenerator     = $idGenerator;
        $this->clock           = $clock;
        $this->randomGenerator = $randomGenerator;
        $this->mailer          = $mailer;
    }

    public function __invoke(Input $input): void
    {
        $user = User::register($input->getUserFirstname(), $input->getUserLastname(), $input->getUserEmail(), $this->idGenerator, $this->clock, $this->randomGenerator);
        $this->users->add($user);

        $farm = Farm::register($input->getFarmName(), $user->getId(), $this->idGenerator, $this->clock);
        $this->farms->add($farm);

        $this->mailer->send(new UserRegisterEmail($user));
    }
}
