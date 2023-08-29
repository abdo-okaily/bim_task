<?php

namespace App\Integrations\Shipping\Interfaces;

use App\Models\Transaction;

interface ShippingIntegration
{
    /**
     * Start Shipping Process ...
     */
    public function createShipment(Transaction $transaction);

    /**
     * Cancel Shipping Process ...
     */
    public function cancelShipment(Transaction $shippingInfo);
}