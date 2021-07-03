<?php

namespace Domain\Entity\Users;

use Domain\Entity\Contracts\UserCustomerInterface;

use GuzzleHttp\Exception\InvalidArgumentException;

use Domain\Name;
use Domain\Cpf;
use Domain\Email;
use Ramsey\Uuid\Type\Decimal;

class Customer implements UserCustomerInterface
{
    private string $id;
    private Name $name;
    private Cpf $cpf;
    private Email $email;
    private string $password;
    private Decimal $balance;

    public function receiveTransfer(Decimal $amount): void
    {
        $newBalance = $this->balance->toString() + $amount->toString();
        $this->balance = new Decimal($newBalance);
    }

    public function transfer(Decimal $amount): void
    {
        if ($amount->toString() > $this->balance->toString()) {
            throw new InvalidArgumentException("Saldo insuficiente para realizar esta transação", 402);
        }

        if ($amount <= new Decimal('0')) {
            throw new InvalidArgumentException("Valor minimo para transação é 0.01 centavos", 403);
        }

        $newBalance = $this->balance->toString() - $amount->toString();

        $this->balance = new Decimal($newBalance);
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function setCpf(Cpf $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setBalance(Decimal $balance): void
    {
        $this->balance = $balance;
    }

    public function getBalance(): Decimal
    {
        return $this->balance;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getCpf(): Cpf
    {
        return $this->cpf;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

}
