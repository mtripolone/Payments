<?php

namespace App\Repositories\Wallet;

use App\Models\Wallet;

class WalletRepository implements WalletRepositoryContract
{
    public function __construct(
        protected Wallet $model
    ) {
    }

    public function findOrFail(int $userId): Wallet
    {
        return  $this->model->findOrFail($userId);
    }
}
