<?php
namespace App\Services\Order\PaymentResponses;

use App\Models\Transaction;
use App\Services\Order\Contracts\PlaceOrderResponseInterface;
use Closure;

class CashResponse implements PlaceOrderResponseInterface {
    private Transaction $transaction;
    private bool $isSuccess;
    private array $data;
    private int $statusCode;
    private string $message;

    public function __construct(Transaction $transaction) {
        $this->transaction = $transaction;
        $this->isSuccess = true;
        $this->data = $this->transaction->toArray();
        $this->statusCode = 200;
        $this->message = __('cart.api.checkout_succesfully');
    }

    /**
     * @return bool
     */
    public function getIsSuccess() : bool {
        return $this->isSuccess;
    }

    /**
     * @return array
     */
    public function getData() : array {
        return $this->data;
    }
    
    /**
     * @return int
     */
    public function getStatusCode() : int {
        return $this->statusCode;
    }
    
    /**
     * @return string
     */
    public function getMessage() : string {
        return $this->message;
    }

    /**
     * @return array
     */
    public function toArray() : array {
        return [
            'success' => $this->getIsSuccess(),
            'status'  => $this->getStatusCode(),
            'data'    => $this->getData(),
            'message' => $this->getMessage(),
        ];
    }

    /**
     * @param Closure $callback
     * @return self
     */
    public function successCallback(Closure $callback) : self {
        if ($this->isSuccess) $callback();
        return $this;
    }

    /**
     * @param Closure $callback
     * @return self
     */
    public function failureCallback(Closure $callback) : self {
        if (!$this->isSuccess) $callback();
        return $this;
    }

    /**
     * @return Transactions
     */
    public function getTransaction() : Transaction {
        return $this->transaction;
    }
}