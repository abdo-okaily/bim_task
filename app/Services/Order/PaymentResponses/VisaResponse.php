<?php
namespace App\Services\Order\PaymentResponses;

use App\Enums\OrderStatus;
use App\Models\Transaction;
use App\Events\Transaction as TransactionEvents;
use App\Services\Order\Contracts\PlaceOrderResponseInterface;
use App\Services\Payments\Urway\Constants as UrwayConstants;
use App\Services\Payments\Urway\UrwayServices;
use Closure;

class VisaResponse implements PlaceOrderResponseInterface {
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
        $this->callUrway();
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
        if (!$this->isSuccess) {
            $this->transaction->update(['status' => OrderStatus::CANCELED]);
            event(new TransactionEvents\Cancelled($this->transaction->load("orders.vendor.wallet.transactions")));
            $callback();
        }
        return $this;
    }

    /**
     * @return Transactions
     */
    public function getTransaction() : Transaction {
        return $this->transaction;
    }

    private function callUrway() {
        $redirectUrl = UrwayServices::generatePaymentUrl($this->transaction);
        if($redirectUrl->result == "UnSuccessful") {
            $this->isSuccess = false;
            $this->data = [];
            $this->statusCode = 500;
            $this->message = __('cart.api.gateway-error');
        } else {
            $this->transaction->urwayTransaction()->create([
                "urway_payment_id" => $redirectUrl->payid,
                "customer_ip" => request()->ip(),
                "currency" => UrwayConstants::currency, // set static according to urway always accept SAR only till this commit change
            ]);
            $this->data = ['link' => $redirectUrl->targetUrl . '?paymentid=' . $redirectUrl->payid];
            $this->message = __('cart.api.payment_order_generated');
        }
    }
}