<?php
namespace App\Services\Order\Contracts;

interface PlaceOrderValidationsInterface {
    public function __construct(CartDataInterface $cartData);
    public function validate() : PlaceOrderCalculationInterface;
}