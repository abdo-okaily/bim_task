<?php

namespace App\Enums;

enum OrderStatus {
    
    Const REGISTERD = 'registered';
    Const PAID = 'paid';
    Const SHIPPING_DONE = 'shipping_done';
    Const IN_DELEVERY = 'in_delivery';
    Const COMPLETED = 'completed';
    Const CANCELED = 'canceled';
    Const REFUND = 'refund';

    /**
     * Get wallet status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::REGISTERD => trans('admin.order_statuses.'.self::REGISTERD),
            self::PAID => trans('admin.order_statuses.'.self::PAID),
            self::SHIPPING_DONE => trans('admin.order_statuses.'.self::SHIPPING_DONE),
            self::IN_DELEVERY => trans('admin.order_statuses.'.self::IN_DELEVERY),
            self::COMPLETED => trans('admin.order_statuses.'.self::COMPLETED),
            self::CANCELED => trans('admin.order_statuses.'.self::CANCELED),
            // self::REFUND => trans('admin.order_statuses.'.self::REFUND) // hold this status till do refund business implementation
        ]; 
    }

    /**
     * Get wallet status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::REGISTERD => [
                "value" => self::REGISTERD, 
                "name" => trans('translation.order_statuses.'.self::REGISTERD),
                "class" => "badge badge-soft-secondary text-uppercase"
            ],
            self::PAID => [
                "value" => self::PAID,
                "name" => trans('translation.order_statuses.'.self::PAID),
                "class" => "badge badge-soft-secondary text-uppercase"
            ],
            self::SHIPPING_DONE => [
                "value" => self::SHIPPING_DONE,
                "name" => trans('translation.order_statuses.'.self::SHIPPING_DONE),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::IN_DELEVERY => [
                "value" => self::IN_DELEVERY,
                "name" => trans('translation.order_statuses.'.self::IN_DELEVERY),
                "class" => "badge badge-soft-primary text-uppercase"
            ],
            self::COMPLETED => [
                "value" => self::COMPLETED,
                "name" => trans('translation.order_statuses.'.self::COMPLETED),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::CANCELED => [
                "value" => self::CANCELED,
                "name" => trans('translation.order_statuses.'.self::CANCELED),
                "class" => "badge badge-soft-danger text-uppercase"
            ],
            // hold this status till do refund business implementation
            /*self::REFUND => [
                "value" => self::REFUND,
                "name" => trans('translation.order_statuses.'.self::REFUND),
                "class" => "badge badge-soft-warning text-uppercase"
            ]*/
        ]; 
    }

    /**
     * Get wallet status depending on app locale.
     *
     * @param bool $status
     * @return string
     */
    public static function getStatus(bool $status): string
    {
        return self::getStatusList()[$status];
    }

    /**
     * Get wallet status with class color depending on app locale.
     *
     * @param int $status
     * @return array
     */
    public static function getStatusWithClass(string $status): array
    {
        return self::getStatusListWithClass()[$status];
    }

    public static function getStatuses(): array
    {
        return [
            self::REGISTERD,
            self::PAID,
            self::SHIPPING_DONE,
            self::IN_DELEVERY,
            self::COMPLETED,
            self::CANCELED,
            // self::REFUND, // hold this status till do refund business implementation
        ]; 
    }

    public static function isStatusHasHigherOrder(string $oldStatus, string $newStatus) : bool {
        if ($oldStatus == $newStatus) true;
        switch($oldStatus) {
            case self::REGISTERD:
                return in_array($newStatus, [self::CANCELED, self::PAID, self::IN_DELEVERY, self::SHIPPING_DONE, self::COMPLETED]);
            case self::PAID:
                return in_array($newStatus, [self::CANCELED, self::IN_DELEVERY, self::SHIPPING_DONE, self::COMPLETED]);
            case self::IN_DELEVERY:
                return in_array($newStatus, [self::CANCELED, self::SHIPPING_DONE, self::COMPLETED]);
            case self::SHIPPING_DONE:
                return in_array($newStatus, [self::CANCELED, self::COMPLETED]);
            case self::COMPLETED:
                return in_array($newStatus, [self::CANCELED]);
        }
        return false;
    }
}