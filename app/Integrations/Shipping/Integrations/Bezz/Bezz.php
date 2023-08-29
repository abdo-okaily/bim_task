<?php
namespace App\Integrations\Shipping\Integrations\Bezz;
use App\Models\OrderShip;
use App\Models\Transaction;
use App\Models\WarehouseIntegration;
use App\Models\VendorWarehouseRequest;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use App\Integrations\Shipping\Interfaces\ShippingIntegration;

class Bezz implements ShippingIntegration
{
    use Logger;

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "bezz-shipping";

    /**
     * Start Shipping Process ...
     */
    public function createShipment(Transaction $transaction) : OrderShip
    {

        (new DataValidationBeforApiCalls)($transaction);
        

        $this->logger(self::LOG_CHANNEL, "BEZZ:StartNewShipment", [], false);

        $transaction->load([
            "customer",
            "addresses.city",
            "products"
        ]);


        $orderShip = (new CreateShipment)($transaction);

        
        $this->logger(self::LOG_CHANNEL, "BEZZ:Finishing_Shipping", $orderShip->toArray(), false);

        return $orderShip;
    }

    /**
     * Cancel Shipping Process ...
     */
    public function cancelShipment(Transaction $transaction) : array
    {
        $this->logger(self::LOG_CHANNEL, "BEZZ:cancelShipment", [], false);
        $orderCancel = (new CancelOrder)($transaction);
        $this->logger(self::LOG_CHANNEL, "BEZZ: " . $orderCancel["message"], $orderCancel, false);
        return $orderCancel;
    }
}