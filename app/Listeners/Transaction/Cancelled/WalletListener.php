<?php

namespace App\Listeners\Transaction\Cancelled;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Enums\WalletTransactionTypes;
use App\Events\Transaction;
use App\Services\Wallet\CustomerWalletService;
use Error;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class WalletListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Transaction\Cancelled $event
     * @return void
     */
    public function handle(Transaction\Cancelled $event)
    {
        try {
            $transaction = $event->getTransaction();
            $depositedAmount = 0;
            if ($transaction->wallet_deduction > 0) {
                $depositedAmount += $transaction->wallet_deduction;
            }
            if (
                // TODO: online payment must be synced here when add new payment
                $transaction->payment_method == PaymentMethods::VISA &&
                $transaction->reminder > 0 && $transaction->onlinePayment
            ) {
                $depositedAmount += $transaction->reminder;
            }

            if ($depositedAmount > 0) {
                CustomerWalletService::deposit(
                    $transaction->customer,
                    $depositedAmount / 100,
                    WalletTransactionTypes::COMPENSATION
                );
            }
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in WalletListener: ". $e->getMessage());
        }
    }
}
