<?php

declare(strict_types=1);

namespace App\Infrastructure\Email;

use App\Domain\Email\Address;
use App\Domain\Email\Email;
use App\Domain\Email\Mailer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address as SymfonyAddress;

class SymfonyMailer implements Mailer
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Email $email): void
    {
        $email = (new TemplatedEmail())
            ->from('no-reply@dpac.com')
            ->to(
                ...array_map(fn (Address $address) => new SymfonyAddress(
                    $address->getAddress(),
                    $address->getName()
                ), $email->getRecipients())
            )
            ->subject($email->getSubject())
            ->htmlTemplate($email->getTemplate())
            ->context($email->getParams())
        ;

        $this->mailer->send($email);
    }
}
