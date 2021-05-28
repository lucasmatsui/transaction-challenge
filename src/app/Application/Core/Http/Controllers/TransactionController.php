<?php

namespace App\Http\Controllers;

use Infrastructure\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    public function __construct(
        private TransactionService $transactionService
    ){}

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $this->transactionService->init($request->all());
            $this->transactionService->transfer();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $e->getCode());
        }

        return response()->json([
            'message' => 'Transferencia feita com sucesso',
            'code' => 201,
        ], 201);
    }
}
