<?php

namespace App\Listeners\Transaction\Created;

use App\Events\Transaction;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class VendorListener
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
     * @param Transaction\Created $event
     * @return void
     */
    public function handle(Transaction\Created $event)
    {
        try {
            $orders = $event->getTransaction()->orders();
            foreach ($orders AS $order)
            {
                $vendorUsers = User::with(['vendor'])
                    ->whereIn('type',['sub-vendor','vendor'])
                    ->where('vendor_id',$order->vendor_id);
                $title = __('admin.notifications.vendor.order.title');
                $message = __('admin.notifications.vendor.order.message') . " " . $order->code;
                $url = url('/vendor/orders/show/' . $order->id);
                foreach ($vendorUsers As $vendorUser)
                {
                    //TODO : Check if the sub-vendor has the permission or not to get notified
                    if($vendorUser->type == 'vendor')
                    {
                        $vendorUser->notify(new SendPushNotification($title,$message,$url,[$vendorUser->fcm_token]));
                    }
                }
            }
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in VendorListener: ". $e->getMessage());
        }
    }
}
