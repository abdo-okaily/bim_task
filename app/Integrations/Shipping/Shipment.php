<?php

namespace App\Integrations\Shipping;

use App\Enums\ShippingMethods;
use App\Integrations\Shipping\Integrations\Torod\Torod;
use App\Integrations\Shipping\Interfaces\ShippingIntegration;
use App\Exceptions\Integrations\Shipping\UndefinedShippingMethodException;
use App\Integrations\Shipping\Integrations\Bezz\Bezz;

class Shipment
{
    /**
     * Factory Method that create new instance of the shipping integration.
     */
    public static function make(int $shippingMethodID) : ShippingIntegration
    {
        switch($shippingMethodID) {
            case ShippingMethods::TOROD:
                return new Torod;
            case ShippingMethods::BEZZ:
                return new Bezz;
        }

        
        
        throw new UndefinedShippingMethodException;
    }
}