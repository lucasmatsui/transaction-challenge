<?php

namespace Tests\Unit;

use Infrastructure\Factories\UserFactory;
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
