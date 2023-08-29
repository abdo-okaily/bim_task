<?php

namespace App\Listeners\Notifications\Vendor;

use App\Events\Admin\Vendor\Warning;
use App\Models\User;
use App\Models\Vendor;
use App\Notifications\SendPushMailNotification;

class VendorWarning
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
     * @param  \App\Events\Admin\Vendor\Warning  $event
     * @return void
     */
    public function handle(Warning $event)
    {
        $vendor_warning = $event->vendorWarning;
        $vendor = Vendor::where('id',$vendor_warning->vendor_id)->first();
        $user = User::where('id',$vendor->user_id)->first();
        $title = __('admin.notifications.vendor.warning.title');
        $message = $vendor_warning->body;
        $url = '';
        $user->notify(new SendPushMailNotification($title,$message,$url,[$user->fcm_token]));
    }
}
