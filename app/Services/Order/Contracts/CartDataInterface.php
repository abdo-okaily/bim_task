<?php
namespace App\Services\Order\Contracts;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;

interface CartDataInterface {
    public function __construct(Cart $cart, Address $address);
    public function isProductsAvailable() : bool;
    public function isProductsHasStock() : bool;
    public function isCartEmpty() : bool;
    public function getAddress() : Address;
    public function cartTotalPrices() : float;
    public function getDeliveryFees() : float;
    public function getCart() : Cart;
    public function getProductsCount() : int;
    public function setCoupon(Coupon $coupon) : CartDataInterface;
    public function getCoupon() : Coupon | null;
}