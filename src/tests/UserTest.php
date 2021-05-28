<?php

namespace Domain\Entity\User\Test\Unit;

use Infrastructure\Factories\UserFactory;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Type\Decimal;

class UserTest extends TestCase
{

    public function testCustomerTransfer(): void
    {
        //arrange
        $expected = new Decimal('1649.9');
        $customer = UserFactory::create(1);
        $customer->setBalance(new Decimal('4000'));

        //act
        $customer->transfer(new Decimal('2350.10'));

        //assert
        $this->assertEquals($expected, $customer->getBalance());
    }

    public function testCustomerMakeNegativeTransfer(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Valor minimo para transação é 0.01 centavos');

        //arrange
        $customer = UserFactory::create(1);
        $customer->setBalance(new Decimal('4000'));

        //act
        $customer->transfer(new Decimal('-1'));
    }

    public function testCustomerReceiveTransfer(): void
    {
        //arrange
        $expected = new Decimal('6350.1');
        $customer = UserFactory::create(1);
        $customer->setBalance(new Decimal('4000'));

        //act
        $customer->receiveTransfer(new Decimal('2350.10'));

        //assert
        $this->assertEquals($expected, $customer->getBalance());
    }

    public function testShopkeeperReceiveTransfer(): void
    {
        //arrange
        $expected = new Decimal('6350.1');
        $shopkeeper = UserFactory::create(2);
        $shopkeeper->setBalance(new Decimal('4000'));

        //act
        $shopkeeper->receiveTransfer(new Decimal('2350.10'));

        //assert
        $this->assertEquals($expected, $shopkeeper->getBalance());
    }
}
