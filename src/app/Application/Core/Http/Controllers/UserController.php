<?php

namespace App\Http\Controllers;

use Domain\Entity\Users\Customer;
use Domain\Entity\Users\Shopkeeper;
use Infrastructure\Repositories\UserRepository;

class UserController extends Controller
{
    public function __construct(
        private UserRepository $user
    ){}

    public function show(string $id)
    {
        try {
            $user = $this->user->getById($id);

            $type = 'Lojista';

            if ($user instanceof Customer) {
                $type = 'Cliente';
            }

            return [
                'id' => $user->getId(),
                'name' => $user->getName()->__toString(),
                'cpf' =>  $user instanceof Customer ? $user->getCpf()->__toString() : '',
                'cnpj' => $user instanceof Shopkeeper ? $user->getCnpj()->__toString() : '',
                'email' => $user->getEmail()->__toString(),
                'balance' => $user->getBalance(),
                'type' => $type
            ];

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], $e->getCode());
        }
    }
}
