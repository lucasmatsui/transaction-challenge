<?php

namespace Infrastructure\Repositories;

use Carbon\Carbon;
use Domain\Entity\Transaction;
use Domain\Repositories\TransactionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class TransactionRepository implements TransactionRepositoryInterface
{

    public function save(Transaction $transaction): void
    {
        $payer = DB::table('users')
            ->where('id', $transaction->getPayer()->getId())
            ->update([
                'balance' => $transaction->getPayer()->getBalance()->toString()
            ]);

        if (!$payer) {
            throw new InvalidArgumentException('Algo deu errado ao fazer a transação', 500);
        }

        $payee = DB::table('users')
            ->where('id', $transaction->getPayee()->getId())
            ->update([
                'balance' => $transaction->getPayee()->getBalance()->toString()
            ]);

        if (!$payee) {
            throw new InvalidArgumentException('Algo deu errado ao fazer a transação', 500);
        }

        $transaction = DB::table('transactions')->insert([
            'id' => Uuid::uuid4()->toString(),
            'id_payer' => $transaction->getPayer()->getId(),
            'id_payee' => $transaction->getPayee()->getId(),
            'amount' => $transaction->getAmount(),
            'created_at' => Carbon::now('America/Sao_Paulo')
        ]);

        if (!$transaction) {
            throw new InvalidArgumentException('Algo deu errado ao fazer a transação', 500);
        }
    }

}
