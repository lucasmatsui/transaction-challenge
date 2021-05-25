<?php

namespace Domain\Entity\Contracts;

use Ramsey\Uuid\Type\Decimal;

interface UserCustomerInterface extends UserInterface
{
    public function transfer(Decimal $amount): void;
}
