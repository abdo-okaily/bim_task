<?php
namespace App\Services\Order\Contracts;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;

interface PlaceOrderDataInterface {
    public function __construct(CartDataInterface $cart);
    public function setCustomer(User $customer) : PlaceOrderDataInterface;
    public function getCustomer() : User;
    public function getCart() : Cart;
    public function getAddress() : Address;
    public function setTotals(PlaceOrderCalculationInterface $placeOrderCalculation) : PlaceOrderDataInterface;
    public function makeTransaction() : PlaceOrderTransactionInterface;
    public function getTotalAmount() : float;
    public function getProductsCount() : int;
    public function getCoupon() : Coupon | null;
}