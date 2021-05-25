<?php

namespace Infrastructure\Repositories;

use Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class UserRepository implements UserRepositoryInterface
{
    public function getById(string $id): array
    {
        $user = DB::table('users')->find($id);

        if (!$user) {
            throw new InvalidArgumentException('Usuário não encontrado', 404);
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'cpf' => $user->cpf,
            'cnpj' => $user->cnpj,
            'email' => $user->email,
            'balance' => $user->balance,
            'type' => $user->id_type
        ];
    }
}
