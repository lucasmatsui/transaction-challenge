<?php

namespace Domain\Services;

use Domain\Entity\Contracts\UserInterface;

interface TransactionServiceInterface
{
    public function init(array $fields = []): void;
    public function getUserInstace(string $id): UserInterface;
    public function transfer(): void;
}
