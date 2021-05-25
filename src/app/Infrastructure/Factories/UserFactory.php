<?php

namespace Infrastructure\Factories;

use Domain\Entity\Users\Customer;
use Domain\Entity\Users\Shopkeeper;
use Domain\Factories\UserFactoryInterface;
use InvalidArgumentException;

class UserFactory implements UserFactoryInterface
{
    const CUSTOMER = 1;
    const SHOPKEPPER = 2;

    public static function create(int $type): Customer|Shopkeeper
    {
        if ($type == self::CUSTOMER) {
            return new Customer();
        }

        if ($type == self::SHOPKEPPER) {
            return new Shopkeeper();
        }

        throw new InvalidArgumentException('Algo deu errado com a trasferencia, tente mais tarde.', 500);
    }
}
