<?php

namespace App\Enums;

enum VendorPermission {
    
    Const ORDERS = 'order';
    Const PRODUCT = 'product';
    Const USER = 'user';
    Const REVIEW = 'review';
    Const ROLE = 'role';
    Const CERTIFICATE = 'certificate';
    Const WAREHOUSE = 'warehouse';

    /**
     * Get wallet permission list depending on app locale.
     *
     * @return array
     */
    public static function getPermissionList(): array
    {
        return [
            self::ORDERS=>trans('translation.permissions_keys.'.self::ORDERS),
            self::PRODUCT=>trans('translation.permissions_keys.'.self::PRODUCT),
            self::USER=>trans('translation.permissions_keys.'.self::USER),
            self::REVIEW=>trans('translation.permissions_keys.'.self::REVIEW),
            self::ROLE=>trans('translation.permissions_keys.'.self::ROLE),
            self::CERTIFICATE=>trans('translation.permissions_keys.'.self::CERTIFICATE),
            self::WAREHOUSE=>trans('translation.permissions_keys.'.self::WAREHOUSE)
        ]; 
    }

    /**
     * Get wallet permission depending on app locale.
     *
     * @param bool $permission
     * @return string
     */
    public static function getPermission($permission): string
    {
        return self::getPermissionList()[$permission];
    }

    /**
     * Get wallet permission with class color depending on app locale.
     *
     * @param int $permission
     * @return array
     */
    public static function getPermissionWithClass(string $permission): array
    {
        return self::getPermissionListWithClass()[$permission];
    }
}