<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;

interface TransactionRepositoryContract
{
    public function where(string $table,int $walletId);
}