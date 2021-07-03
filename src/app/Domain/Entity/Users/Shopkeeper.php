<?php

namespace Domain\Entity\Users;

use Domain\Entity\Contracts\UserInterface;

use Domain\Name;
use Domain\Cnpj;
use Domain\Email;
use Ramsey\Uuid\Type\Decimal;

class Shopkeeper implements UserInterface
{
    private string $id;
    private Name $name;
    private Cnpj $cnpj;
    private Email $email;
    private string $password;
    private Decimal $balance;

    public function receiveTransfer(Decimal $amount): void
    {
        $newBalance = $this->balance->toString() + $amount->toString();
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

    public function setCnpj(Cnpj $cnpj): void
    {
        $this->cnpj = $cnpj;
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

    public function getCnpj(): Cnpj
    {
        return $this->cnpj;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
