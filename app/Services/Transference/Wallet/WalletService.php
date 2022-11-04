<?php

namespace App\Services\Transference\Wallet;

use App\Repositories\User\UserRepository;
use App\Services\Transference\Authorization\AuthorizeService;
use App\Services\Transference\Notification\NotificationService;
use App\Services\Transference\User\Rules\ProfileRule;
use App\Services\Transference\User\Rules\WalletBalanceRule;
use App\Services\Transference\User\Transactions\ExpensesService;
use App\Services\Transference\User\Transactions\InvoceService;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class WalletService
{
    public function __construct(
        protected ProfileRule $profileRule,
        protected WalletBalanceRule $balanceRule,
        protected UserRepository $userRepository,
        protected AuthorizeService $authService,
        protected NotificationService $notifyService,
        protected InvoceService $invoceService,
        protected ExpensesService $expensesService,
    ) {
    }

    public function walletTransfer(array $transfer)
    {
        try {
            DB::beginTransaction();

            // acha os usuarios
            $payer = $this->userRepository->findOrFail($transfer['payer']);
            $payee = $this->userRepository->findOrFail($transfer['payee']);

            // Valida Tipo Profile
            $this->profileRule->validateProfileType($payer->profile);

            // Valida Saldo da conta
            $this->balanceRule->checkWalletBalance($transfer['value'], $payer);

            // Autoriza Transferencia
            $this->authService->transferAuthorizator();

            // Payer Wallet Transfer
            $payer->wallet->balance -= $transfer['value'];
            $payer->wallet->save();
            $this->invoceService->saveInvoceTransaction($transfer['value'], $payer ,$payee);

            // Payee Wallet Transfer
            $payee->wallet->balance += $transfer['value'];
            $payee->wallet->save();
            $this->expensesService->saveExpensesTransaction($transfer['value'], $payer, $payee);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response($e->getMessage(),
                $e->getCode() == 0
                ? Response::HTTP_NOT_FOUND
                : Response::HTTP_UNAUTHORIZED);
        }

        try {
            // Notificação pós transação
            $this->notifyService->notifyClient();

            return response('Transação Efetuada com Sucesso', Response::HTTP_OK);

        } catch (Exception $e) {
            return response('Transação Efetuada com Sucesso, porém, O Envio de e-mail está indisponivel',
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
