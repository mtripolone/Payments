<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Repositories\Transaction\TransactionRepository;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function __construct(
        protected TransactionRepository $repository
    ) {
    }

    public function userTransactions(Request $request)
    {
        $historic = [];

        $transactions = $this->repository->where('from_id', $request->wallet)->get();

        foreach ($transactions as $transaction)
        {
            $valueFormated = number_format($transaction['value'], 2, ',' ,'.');
            $historic[] = "Transaction Type: {$transaction['payments']} of $ {$valueFormated}";
        }

        return response()->json($historic);
    }
}
