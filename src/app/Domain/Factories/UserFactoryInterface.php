<?php

namespace Domain\Factories;

use Domain\Entity\Contracts\UserInterface;

interface UserFactoryInterface
{
    public static function create(int $type): UserInterface;
}
