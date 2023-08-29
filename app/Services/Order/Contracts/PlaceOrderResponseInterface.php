<?php
namespace App\Services\Order\Contracts;

use App\Models\Transaction;
use Closure;

interface PlaceOrderResponseInterface {
    public function __construct(Transaction $transaction);
    public function getIsSuccess() : bool;
    public function getData() : array;
    public function getStatusCode() : int;
    public function getMessage() : string;
    public function toArray() : array;
    public function successCallback(Closure $callback) : PlaceOrderResponseInterface;
    public function failureCallback(Closure $callback) : PlaceOrderResponseInterface;
    public function getTransaction() : Transaction;
}