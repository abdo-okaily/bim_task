<?php

namespace App\Console\Commands\Transaction;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Models\Transaction;
use App\Events\Transaction as TransactionEvents;
use App\Services\Payments\Urway\UrwayServices;
use Exception;
use Illuminate\Console\Command;

class CancelUnpaidForTenMinutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:cancel-unpaid-for-ten-minutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to cancel unpaid transaction with online payment method and created from ten minutes ago';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Transaction::createdTenMinutesAgo()
            ->status(OrderStatus::REGISTERD)
            ->payment(PaymentMethods::VISA)
            ->with("orders.vendor.wallet.transactions", "urwayTransaction")
            ->get()
            ->each(function($transaction) {
                echo "Working on transaction: {$transaction->id}".PHP_EOL;
                $isPaid = false;
                try {
                    $isPaid = UrwayServices::transactionInquiry($transaction);
                } catch (Exception $e) {
                    $isPaid = false;
                }

                if ($isPaid) {
                    $transaction->update(['status' => OrderStatus::PAID]);
                    event(new TransactionEvents\Created($transaction));
                } else {
                    $transaction->update(['status' => OrderStatus::CANCELED]);
                    event(new TransactionEvents\Cancelled($transaction));
                }
            });
        return Command::SUCCESS;
    }
}
