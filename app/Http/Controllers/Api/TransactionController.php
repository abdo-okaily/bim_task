<?php
namespace App\Http\Controllers\Api;

use App\Enums\PaymentMethods;
use Illuminate\Http\JsonResponse;
use App\Services\Api\TransactionService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\CartResource;
use Illuminate\Http\Request;
use App\Http\Requests\Api\CheckoutRequest;
use App\Http\Requests\Api\PayWithWalletRequest;
use App\Http\Requests\Api\TransactionRateStore;
use App\Services\Api\TransactionServiceReader;

class TransactionController extends ApiController
{
    /**
     * Cart Controller Constructor.
     *
     * @param CartService $service
     */
    public function __construct(
        private TransactionService $service,
        private TransactionServiceReader $readerService
    ) {
        $this->middleware('api.auth')->except(['pay_callback']);
    }

    /**
     * List all user Trasactions.
     *
     * @return JsonResponse
     */
    public function userOrders() : JsonResponse
    {
        $response = $this->readerService->getUserOrders();
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );

    }

    /**
     * List user current orders.
     *
     * @return JsonResponse
     */
    public function trackUserOrders() : JsonResponse
    {
        $response = $this->readerService->trackUserCurrentOrders();
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    /**
     * get order daitails.
     *
     * @param transaction_id
     * @return JsonResponse
     */
    public function orderDetails(int $transaction_id) : JsonResponse
    {
        $response = $this->readerService->getOrderDetails($transaction_id);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    public function getOrderDetailsForRate(int $transaction_id) : JsonResponse
    {
        $response = $this->readerService->getOrderDetailsForRate($transaction_id);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    public function saveOrderRate(int $transaction_id ,TransactionRateStore $request)
    {
        $response = $this->service->setCustomerId(auth('api')->user()->id)->saveOrderRate($transaction_id, $request);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    public function checkout(CheckoutRequest $request)
    {
        $response = $this->service->setCustomerId(auth('api')->user()->id)->cashCheckout($request);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
    
    public function payWithWallet(PayWithWalletRequest $request)
    {
        $response = $this->service->setCustomerId(auth('api')->user()->id)->walletCheckout($request);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
    
    public function pay(CheckoutRequest $request)
    {
        $response = $this->service->setCustomerId(auth('api')->user()->id)->generatePaymentRequest($request);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    public function pay_callback(Request $request)
    {
        return $this->service->paymentCallback($request);
    }

}
