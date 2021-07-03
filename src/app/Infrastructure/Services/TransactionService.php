<?php

namespace Infrastructure\Services;

use App\Jobs\ProcessEmailJob;
use Domain\Entity\Transaction;
use Domain\Services\TransactionServiceInterface;
use Infrastructure\Repositories\TransactionRepository;
use Infrastructure\Repositories\UserRepository;
use Ramsey\Uuid\Type\Decimal;

class TransactionService implements TransactionServiceInterface
{

    private $payer;
    private $payee;
    private $amount;

    public function __construct(
        private UserRepository $userRepository,
        private TransactionRepository $transactionRepository,
    ){}

    public function init(array $fields = []): void
    {
        $this->payer = $fields['payer'];
        $this->payee = $fields['payee'];
        $this->amount = $fields['amount'];
    }
    public function transfer(): void
    {
        $payer = $this->userRepository->getById($this->payer);
        $payee = $this->userRepository->getById($this->payee);

        $transaction = new Transaction(
            $payer,
            $payee,
            new Decimal($this->amount)
        );

        $this->transactionRepository->save($transaction->make());
        dispatch(new ProcessEmailJob($payee));
    }

}
