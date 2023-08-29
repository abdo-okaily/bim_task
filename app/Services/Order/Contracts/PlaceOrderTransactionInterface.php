<?php
namespace App\Services\Order\Contracts;


interface PlaceOrderTransactionInterface {
    public function __construct(PlaceOrderDataInterface $placeOrderData);
    public function setUsingWallet(bool $usingWallet) : PlaceOrderTransactionInterface;
    public function setPaymentMethod(int $paymentMethod) : PlaceOrderTransactionInterface;
    public function saveTransaction() : PlaceOrderResponseInterface;
}