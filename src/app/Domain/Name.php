<?php

namespace Domain;

use InvalidArgumentException;
use Stringable;

class Name implements Stringable
{
    private string $name;

    public function __construct(string $name)
    {
        if(!preg_match("/^([a-zA-Z' ]+)$/", $name)){
           throw new InvalidArgumentException('Nome inválido', 400);
        }

        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
