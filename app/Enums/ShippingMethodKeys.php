<?php
namespace App\Enums;

enum ShippingMethodKeys {
    const BEZZ_KEY = "national-shipping-method-BEZZ";

    public static function getKeys() : array {
        return [
            self::BEZZ_KEY => __('admin.shippingMethods.bezz'),
        ];
    }

    public static function getKeysArray()
    {
        return [
            self::BEZZ_KEY
        ];
    }
}