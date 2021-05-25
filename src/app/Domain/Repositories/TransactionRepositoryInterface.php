<?php

namespace Domain\Repositories;

use Domain\Entity\Transaction;

interface TransactionRepositoryInterface
{
    public function save(Transaction $transaction): void;
}
