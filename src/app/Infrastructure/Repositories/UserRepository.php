<?php

namespace Infrastructure\Repositories;

use Domain\Cnpj;
use Domain\Cpf;
use Domain\Email;
use Domain\Name;

use Domain\Entity\Users\Shopkeeper;
use Domain\Entity\Users\Customer;
use Infrastructure\Factories\UserFactory;
use Domain\Repositories\UserRepositoryInterface;

use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Decimal;

use InvalidArgumentException;

class UserRepository implements UserRepositoryInterface
{
    public function getById(string $id): Customer|Shopkeeper
    {
        $user = DB::table('users')->find($id);

        if (!$user) {
            throw new InvalidArgumentException('Usuário não encontrado', 404);
        }

        $userFactory = UserFactory::create($user->id_type);
        $userFactory->setId($user->id);
        $userFactory->setName(new Name($user->name));

        if ($userFactory instanceof Customer) {
            $userFactory->setCpf(new Cpf($user->cpf));
        }

        if ($userFactory instanceof Shopkeeper) {
            $userFactory->setCnpj(new Cnpj($user->cnpj));
        }

        $userFactory->setEmail(new Email($user->email));
        $userFactory->setBalance(new Decimal($user->balance));

        return $userFactory;
    }
}
