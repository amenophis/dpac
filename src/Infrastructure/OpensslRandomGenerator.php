<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\RandomGenerator;

class OpensslRandomGenerator implements RandomGenerator
{
    /**
     * Original credit to Laravel's Str::random() method.
     *
     * String length is 20 characters
     */
    public function generate(int $length): string
    {
        $string = '';

        while (($len = \strlen($string)) < 20) {
            $size = $length - $len;

            $bytes = \openssl_random_pseudo_bytes($size);

            $string .= \substr(
                \str_replace(['/', '+', '='], '', \base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}
