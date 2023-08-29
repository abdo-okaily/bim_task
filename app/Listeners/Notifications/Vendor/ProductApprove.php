<?php

namespace App\Listeners\Notifications\Vendor;

use App\Events\Admin\Product\Approve;
use App\Models\User;
use App\Models\Vendor;
use App\Notifications\SendPushNotification;

class ProductApprove
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
     * @param  \App\Events\Admin\Product\Approve  $event
     * @return void
     */
    public function handle(Approve $event)
    {
        $title = __('admin.notifications.vendor.product.approve.title') . $event->product->name;
        $message = __('admin.notifications.vendor.product.approve.message');
        $url = url('/vendor/products/show/' . $event->product->id);
        $vendor = Vendor::where('id',$event->product->vendor_id)->first();
        $user = User::where('id',$vendor->user_id)->first();
        $user->notify(new SendPushNotification($title,$message,$url,[$user->fcm_token]));
    }
}
