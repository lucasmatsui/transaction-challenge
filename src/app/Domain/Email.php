<?php

namespace Domain;

use InvalidArgumentException;
use Stringable;

class Email implements Stringable
{
    private string $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email inválido!", 400);
        }

        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
