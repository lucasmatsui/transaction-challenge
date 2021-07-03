<?php

namespace Domain\Repositories;

use Domain\Entity\Users\Customer;
use Domain\Entity\Users\Shopkeeper;

interface UserRepositoryInterface
{
    public function getById(string $id): Customer|Shopkeeper;
}
