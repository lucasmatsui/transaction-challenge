<?php

namespace Domain\Entity\Contracts;

use Ramsey\Uuid\Type\Decimal;

interface UserInterface
{
    public function setId(string $id): void;
    public function getId(): string;

    public function setBalance(Decimal $balance): void;
    public function getBalance(): Decimal;

    public function receiveTransfer(Decimal $amount): void;
}
