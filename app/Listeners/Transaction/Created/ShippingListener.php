<?php

namespace App\Listeners\Transaction\Created;
use Exception;
use App\Events\Transaction;
use App\Integrations\Shipping\Shipment;
use App\Models\TransactionWarning;
use Error;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ShippingListener
{
  
    /**
     * Trod Const Number
     */
    public const TOROD = 1;

    /**
     * Bezz Const Number
     */
    public const BEZZ = 2;
    /**
     * Handle the event.
     *
     * @param Transaction\Created $event
     * @return void
     */
    public function handle(Transaction\Created $event)
    {
        $transaction = $event->getTransaction();
        try{
            Shipment::make(self::BEZZ)->createShipment($transaction);
        } catch (Exception $e) {
            TransactionWarning::create([
                'message' => $e->getMessage(),
                'reference_type' => 'BeezShipment',
                'transaction_id' => $transaction->id,
            ]);
        } catch (Error $e) {
            TransactionWarning::create([
                'message' => "internal system error",
                'reference_type' => 'BeezShipment',
                'transaction_id' => $transaction->id,
            ]);
        }
    }
}
