<?php

namespace App\Enums;

enum ShippingMethods {
    
    /**
     * Torod Shipping State.
     */
    public const TOROD = 1;

    public const BEZZ =2;


    /**
     * Get List of shipping companies list depending on app locale.
     *
     * @return array
     */
    public static function getStateList(): array
    {
        return [
            self::TOROD => trans('admin.shippingMethods.torod'),
            self::BEZZ => trans('admin.shippingMethods.bezz')

        ]; 
    }

    /**
     * Get List of shipping companies list with value and name depending on app locale.
     *
     * @return array
     */
    public static function getStateListOneLevel(): array
    {
        return [
            ["value" => self::TOROD, "name" => trans('admin.shippingMethods.torod')],
            ["value" => self::BEZZ, "name" => trans('admin.shippingMethods.bezz')]


        ]; 
    }

    /**
     * Get shipping compaines list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStateListWithClass(): array
    {
        return [
            self::TOROD => [
                "value" => self::TOROD, 
                "name" => trans('admin.shippingMethods.torod'),
                "class" => "badge badge-soft-warning text-uppercase"
            ],

            self::BEZZ => [
                "value" => self::BEZZ, 
                "name" => trans('admin.shippingMethods.bezz'),
                "class" => "badge badge-soft-warning text-uppercase"
            ],
        ]; 
    }

    /**
     * Get single shipping company states depending on app locale.
     *
     * @param int|null $state
     * @return string
     */
    public static function getState(int|null $state): string
    {
        return self::getStateList()[$state];
    }

    /**
     * Get single shipping company states with class color depending on app locale.
     *
     * @param int|null $state
     * @return array
     */
    public static function getStateWithClass(int|null $state): array
    {
        return self::getStateListWithClass()[$state];
    }
}