<?php

declare(strict_types=1);

namespace App\Application\Supplier\Register;

use Symfony\Component\Validator\Constraints as Assert;

class FormDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="64")
     */
    public string $name;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    public string $email;
}
