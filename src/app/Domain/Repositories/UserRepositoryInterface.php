<?php

namespace Domain\Repositories;

interface UserRepositoryInterface
{
    public function getById(string $id): array;
}
