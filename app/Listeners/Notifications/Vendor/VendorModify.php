<?php

namespace App\Listeners\Notifications\Vendor;

use App\Events\Admin\Vendor\Modify;
use App\Models\User;
use App\Notifications\SendPushNotification;

class VendorModify
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
     * @param  \App\Events\Admin\Vednor\Modify  $event
     * @return void
     */
    public function handle(Modify $event)
    {
        $title = __('admin.notifications.vendor.modify.title');
        $message = __('admin.notifications.vendor.modify.message');
        $url = url('/vendor/edit-profile');
        $user = User::where('id',$event->vendor->user_id)->first();
        $user->notify(new SendPushNotification($title,$message,$url,[$user->fcm_token]));
    }
}
