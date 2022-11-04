<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\TransferRequest;
use App\Services\Transference\Wallet\WalletService;

class TransferController extends Controller
{
    public function __construct(
        protected WalletService $walletService,
    ) {
    }

    public function transference(TransferRequest $request)
    {
        $transfer = $request->validated();

        return $this->walletService->walletTransfer($transfer);
    }
}
