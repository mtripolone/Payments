<?php

namespace App\Services\Transference\User\Rules;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class WalletBalanceRule
{
    public function checkWalletBalance($value, $user)
    {
        if ($value > $user->wallet->balance) {
            throw new Exception('Saldo da carteira insuficiente', Response::HTTP_UNAUTHORIZED);
        }
    }
}
