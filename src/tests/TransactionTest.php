<?php

namespace Domain\Entity\Transaction\Test\Integration;

use Domain\Entity\Transaction;
use Infrastructure\Factories\UserFactory;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Type\Decimal;

class TransactionTest extends TestCase
{
    public function transactionDataProvider()
    {
        return [
            [
                [
                    'id' => 'f8923cf0-df67-4c82-ad2c-b8ece5a5c59c',
                    'balance' => '4000',
                    'id_type' => 1
                ],
                [
                    'id' => 'f260d63f-837f-4491-bdbd-f05f570c196e',
                    'balance' => '2500.10',
                    'id_type' => 2
                ]
            ],
        ];
    }

    /**
     * @dataProvider transactionDataProvider
     */
    public function testMakeTransaction($payerTest, $payeeTest)
    {
        //arrange

        $payer = UserFactory::create($payerTest['id_type']);
        $payer->setId($payerTest['id']);
        $payer->setBalance(new Decimal($payerTest['balance']));

        $payee = UserFactory::create($payeeTest['id_type']);
        $payee->setId($payeeTest['id']);
        $payee->setBalance(new Decimal($payeeTest['balance']));

        $amount = new Decimal('250.15');

        $expectedPayer = new Decimal('3749.85');
        $expectedPayee = new Decimal('2750.25');

        //act
        $transaction = new Transaction(
            $payer,
            $payee,
            $amount
        );
        $transaction->make();

        //assert
        $this->assertEquals($expectedPayer, $transaction->getPayer()->getBalance());
        $this->assertEquals($expectedPayee, $transaction->getPayee()->getBalance());
    }

    /**
     * @dataProvider transactionDataProvider
     */
    public function testShopkeeperMakeTransaction($payerTest, $payeeTest)
    {
        $this->expectException(\Carbon\Exceptions\InvalidTypeException::class);
        $this->expectExceptionMessage('Lojistas não podem fazer transferencias');

        //arrange
        $payer = UserFactory::create($payerTest['id_type']);
        $payer->setId($payerTest['id']);
        $payer->setBalance(new Decimal($payerTest['balance']));

        $payee = UserFactory::create($payeeTest['id_type']);
        $payee->setId($payeeTest['id']);
        $payee->setBalance(new Decimal($payeeTest['balance']));

        $amount = new Decimal('250.15');

        //act
        $transaction = new Transaction(
            $payee,
            $payer,
            $amount
        );
        $transaction->make();
    }

    /**
     * @dataProvider transactionDataProvider
     */
    public function testMakeTransactionForYourself($payerTest, $payeeTest)
    {
        $this->expectException(\Ramsey\Uuid\Exception\InvalidUuidStringException::class);
        $this->expectExceptionMessage('Não é possivel transferir para a sua própria conta');

        //arrange
        $payer = UserFactory::create($payerTest['id_type']);
        $payer->setId($payerTest['id']);
        $payer->setBalance(new Decimal($payerTest['balance']));

        $amount = new Decimal('250.15');

        //act
        $transaction = new Transaction(
            $payer,
            $payer,
            $amount
        );
        $transaction->make();
    }

}
