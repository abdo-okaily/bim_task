<?php

namespace App\Listeners\Transaction\Created;

use App\Events\Transaction;
use App\Services\NotificationCenterService;
use Error;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CustomerListener
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
     * @param  Transaction\Created  $event
     * @return void
     */
    public function handle(Transaction\Created $event)
    {
        try {
            $transaction = $event->getTransaction();
            $customer = $transaction->customer;
            (new NotificationCenterService)->toSms([
                'user' => $customer,
                'message' => "شكرا يا {$customer->name}, تم إستلام طلبك رقم:{$transaction->code} بقيمة: {$transaction->total_amount_rounded} ر.س بنجاح",
            ]);
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in Created/CustomerListener: ". $e->getMessage());
        }
    }
}
