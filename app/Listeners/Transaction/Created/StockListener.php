<?php

namespace App\Listeners\Transaction\Created;

use App\Events\Transaction;
use Error;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class StockListener
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
     * @param Transaction\Created  $event
     * @return void
     */
    public function handle(Transaction\Created $event)
    {
        try {
            $transaction = $event->getTransaction()->load(['orders.orderProducts.product']);
            $transaction->orders->each(function ($order) {
                $order->orderProducts->each(function ($orderProduct) {
                    $orderProduct->product->decrement("stock", $orderProduct->quantity);
                });
            });
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in StockListener: ". $e->getMessage());
        }
    }
}
