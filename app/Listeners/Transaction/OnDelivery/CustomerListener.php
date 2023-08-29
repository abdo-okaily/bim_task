<?php

namespace App\Listeners\Transaction\OnDelivery;

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
     * @param Transaction\OnDelivery $event
     * @return void
     */
    public function handle(Transaction\OnDelivery $event)
    {
        try {
            $transaction = $event->getTransaction();
            $customer = $transaction->customer;
            (new NotificationCenterService())->toSms([
                'user' => $customer,
                'message' => "{$customer->name}, جاري توصيل طلبك رقم:{$transaction->code}",
            ]);
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in OnDelivery/CustomerListener: ". $e->getMessage());
        }
    }
}
