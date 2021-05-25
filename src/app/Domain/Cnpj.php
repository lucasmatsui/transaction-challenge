<?php

namespace Domain;

use InvalidArgumentException;
use Stringable;

class Cnpj implements Stringable
{
    private string $cnpj;

    public function __construct(string $cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        if (strlen($cnpj) != 14)
            throw new InvalidArgumentException("Cnpj inválido!", 400);

        if (preg_match('/(\d)\1{13}/', $cnpj))
            throw new InvalidArgumentException("Cnpj inválido!", 400);

        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            throw new InvalidArgumentException("Cnpj inválido!", 400);

        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);

        $this->cnpj = $cnpj;
    }

    public function __toString(): string
    {
        return $this->cnpj;
    }
}
