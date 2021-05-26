<?php

namespace Domain\Entity;

use Carbon\Exceptions\InvalidTypeException;
use Domain\Entity\Contracts\UserCustomerInterface;
use Domain\Entity\Contracts\UserInterface;
use Domain\Entity\Users\Shopkeeper;
use GuzzleHttp\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Type\Decimal;

class Transaction
{
    /**
     * @param UserCustomerInterface $payer
     */
    public function __construct(
        private UserInterface $payer,
        private UserInterface $payee,
        private Decimal $amount,
    ){}

    private function isAuthorized(): bool
    {
        $response = Http::get(env('URL_AUTH_TRANSACTION'));
        $response = $response->json();

        if ($response['message'] != 'Autorizado') {
            return false;
        }

        return true;
    }

    public function make(): self
    {

        if ($this->payer instanceof Shopkeeper) {
            throw new InvalidTypeException('Lojistas não podem fazer transferencias', 400);
        }

        if ($this->payer->getId() == $this->payee->getId()) {
            throw new InvalidUuidStringException('Não é possivel transferir para a sua própria conta', 400);
        }

        $this->payer->transfer(new Decimal($this->amount));
        $this->payee->receiveTransfer(new Decimal($this->amount));

        if (!$this->isAuthorized()) {
            throw new InvalidArgumentException('Algo deu errado com a trasferencia, tente mais tarde.', 500);
        }

        return $this;
    }

    public function getPayer()
    {
        return $this->payer;
    }

    public function getPayee()
    {
        return $this->payee;
    }

    public function getAmount()
    {
        return $this->amount;
    }


}
