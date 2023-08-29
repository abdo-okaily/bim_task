<?php

namespace App\Listeners\Transaction\Delivered;

use Error;
use Exception;
use App\Events\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\NotificationCenterService;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param Transaction\Delivered $event
     * @return void
     */
    public function handle(Transaction\Delivered $event)
    {
        try {
            $transaction = $event->getTransaction();
            $customer = $transaction->customer;

            $msg = "::var_client_name::،\n".
                "طلبك ::var_order_id_rand:: بين ايديك، هني وعافية\n".
                "ولا تنسانا بتقييم الطلب\n".
                "::var_link_order::";

            $frontUrl = env("WEBSITE_BASE_URL"). "/user/rating-order/{$transaction->id}";

            $msg = Str::replace("::var_client_name::", $customer->name, $msg);
            $msg = Str::replace("::var_order_id_rand::", $transaction->code, $msg);
            $msg = Str::replace("::var_link_order::", $frontUrl, $msg);
            
            (new NotificationCenterService)->toSms(['user' => $customer, 'message' => $msg,]);
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in Delivered/CustomerListener: ". $e->getMessage());
        }
    }
}
