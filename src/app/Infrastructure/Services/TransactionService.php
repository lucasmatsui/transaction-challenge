<?php

namespace Infrastructure\Services;

use App\Jobs\ProcessEmailJob;
use Domain\Entity\Contracts\UserInterface;
use Domain\Entity\Transaction;
use Domain\Services\TransactionServiceInterface;
use Infrastructure\Factories\UserFactory;
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

    public function getUserInstace(string $id): UserInterface
    {
        $user = $this->userRepository->getById($id);
        $type = isset($user['type']) ? $user['type'] : '';

        $UserInstance = UserFactory::create($type);
        $UserInstance->setId($user['id']);
        $UserInstance->setBalance(new Decimal($user['balance']));

        return $UserInstance;
    }


    public function transfer(): void
    {
        $payer = $this->getUserInstace($this->payer);
        $payee = $this->getUserInstace($this->payee);

        $transaction = new Transaction(
            $payer,
            $payee,
            new Decimal($this->amount)
        );

        $this->transactionRepository->save($transaction->make());
        dispatch(new ProcessEmailJob($payee));
    }

}
