<?php

namespace App\Integrations\Shipping\Integrations\Torod;

use App\Integrations\Shipping\Interfaces\ShippingIntegration;

class Aramax implements ShippingIntegration
{
    /**
     * Start Shipping Process ...
     */
    public function createShipment(array $order)
    {
        return ["message" => "Aramax Shipment cancel success"];
    }

    /**
     * Cancel Shipping Process ...
     */
    public function cancelShipment(array $order)
    {
        return ["message" => "Aramax Shipment cancel success"];
    }
}