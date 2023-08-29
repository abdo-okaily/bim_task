<?php
namespace App\Services\Order\Contracts;

interface PlaceOrderCalculationInterface {
    public function __construct(CartDataInterface $cartData);
    public function setDeliveryFees(float $deliveryAmount) : self;
    public function setTotal(float $total) : self;
    public function calculate() : PlaceOrderDataInterface;
    public function getTotalVat() : float;
    public function getSubTotal() : float;
    public function getTotal() : float;
    public function getTotalWithoutVat() : float;
    public function getVatRate() : float;
    public function getVatPercentage() : float;
    public function getDeliveryFees() : float;
    public function getDiscount() : float;
    public function getCalculationsInSr() : array;
}