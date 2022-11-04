<?php

namespace App\Repositories\Wallet;

use App\Models\Wallet;

interface WalletRepositoryContract
{
    public function findOrFail(int $userId): Wallet;
}