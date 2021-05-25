<?php

namespace Domain;

use InvalidArgumentException;
use Stringable;

class Cpf implements Stringable
{
    private string $cpf;

    public function __construct(string $cpf)
    {
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        if (strlen($cpf) != 11) {
            throw new InvalidArgumentException("Cpf inválido!", 400);
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            throw new InvalidArgumentException("Cpf inválido!", 400);
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                throw new InvalidArgumentException("Cpf inválido!", 400);
            }
        }

        $this->cpf = $cpf;
    }

    public function __toString(): string
    {
        return $this->cpf;
    }
}
