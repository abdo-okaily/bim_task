<?php

namespace App\Enums;

enum PaymentMethods {
    /**
     * the pay method is cash.
     */
    public const CASH = 1;

    /**
     * the pay method is visa.
     */
    public const VISA = 2;

    /**
     * the whole arder wallet.
     */
    public const WALLET = 3;

    /**
     * Get wallet attachments status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::CASH => trans('admin.customer_finances.payment_methods.cash'),
            self::VISA => trans('admin.customer_finances.payment_methods.visa'),
            self::WALLET => trans('admin.customer_finances.payment_methods.wallet')
        ];
    }

    /**
     * Get wallet attachments status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::CASH => [
                "value" => self::CASH,
                "name" => trans('admin.customer_finances.payment_methods.cash'),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::VISA => [
                "value" => self::VISA,
                "name" => trans('admin.customer_finances.payment_methods.visa'),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::WALLET => [
                "value" => self::WALLET,
                "name" => trans('admin.customer_finances.payment_methods.wallet'),
                "class" => "badge badge-soft-success text-uppercase"
            ],
        ];
    }

    /**
     * Get wallet attachment status depending on app locale.
     *
     * @param bool $is_has_attachment
     * @return string
     */
    public static function getStatus(int $status_id): string
    {
        return self::getStatusList()[$status_id];
    }

    /**
     * Get wallet attachment status with class color depending on app locale.
     *
     * @param int $is_has_attachment
     * @return array
     */
    public static function getStatusWithClass(int $status_id): array
    {
        return self::getStatusListWithClass()[$status_id];
    }
}
