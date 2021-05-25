<?php

namespace App\Http\Controllers;

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

            return $user;
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 404
            ], 404);
        }
    }
}
