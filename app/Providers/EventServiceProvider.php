<?php

namespace App\Providers;

use App\Events\Transaction as TransactionEvents;
use App\Listeners\Transaction as TransactionListeners;

use App\Events\Admin\Vendor as AdminVendorEvents;
use App\Events\Admin\Product as AdminProductEvents;
use App\Listeners\Notifications\Vendor as NotificationsVendorListeners;

use App\Events\Warehouse\CreateVendorWarehouseRequest;
use App\Listeners\Warehouse\BeezSotrageRequestListener;
use App\Models\Transaction;
use App\Observers\TransactionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CreateVendorWarehouseRequest::class => [
            BeezSotrageRequestListener::class,
        ],

        // check this task to validate the needed business from Client
        // https://hub.tasksa.dev/bapplite/#app/todos/project-7238331330/list-262852053359/task-292466220055
        TransactionEvents\Created::class => [
            TransactionListeners\Created\CustomerListener::class,
            TransactionListeners\Created\AdminListener::class,
            TransactionListeners\Created\VendorListener::class,
            TransactionListeners\Created\StockListener::class,
            TransactionListeners\Created\ShippingListener::class,
            TransactionListeners\Created\InvoiceListener::class,
        ],
        TransactionEvents\Cancelled::class => [
            TransactionListeners\Cancelled\WalletListener::class,
            TransactionListeners\Cancelled\VendorWalletListener::class,
        ],
        TransactionEvents\OnDelivery::class => [
            TransactionListeners\OnDelivery\CustomerListener::class,
        ],
        TransactionEvents\Delivered::class => [
            TransactionListeners\Delivered\CustomerListener::class,
            TransactionListeners\Delivered\VendorWalletListener::class,
        ],
        TransactionEvents\Completed::class => [
            TransactionListeners\Completed\VendorWalletListener::class,
            TransactionListeners\Completed\CustomerListener::class,
        ],
        AdminVendorEvents\Modify::class => [
            NotificationsVendorListeners\VendorModify::class,
        ],
        AdminVendorEvents\Warning::class => [
            NotificationsVendorListeners\VendorWarning::class,
        ],
        AdminProductEvents\Approve::class =>[
            NotificationsVendorListeners\ProductApprove::class,
        ],
        AdminProductEvents\Reject::class =>[
            NotificationsVendorListeners\ProductReject::class,
        ],
        AdminProductEvents\Modify::class =>[
            NotificationsVendorListeners\ProductModify::class,
        ],
    ];

    protected $observers = [
        Transaction::class => [TransactionObserver::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
