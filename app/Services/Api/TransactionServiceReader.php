<?php
namespace App\Services\Api;

use App\Enums\OrderStatus;
use App\Http\Resources\Api\OrderResource;
use App\Http\Resources\Api\OrderTrackingResource;
use App\Http\Resources\Api\TransactionDeatailsResource;
use App\Http\Resources\Api\TransactionForRateResource;
use App\Http\Resources\Api\TransactionResource;
use App\Models\Order;
use App\Models\Transaction;

/**
 * This class for all read operations from Database
 */
class TransactionServiceReader {
    /**
     * @param $customerId
     * @return array
     */
    public function getUserOrders($customerId = null) {
        if ($customerId == null) $customerId = auth('api')->user()->id;

        return [
            'success' => true, 
            'status' => 200,
            'data' => TransactionResource::collection(Transaction::query()->descOrder()->customer($customerId)->get()),
            'message' => __('order.api.retrieved')
        ];
    }

    /**
     * @param $customerId
     * @return array
     */
    public function trackUserCurrentOrders($customerId = null) {
        if ($customerId == null) $customerId = auth('api')->user()->id;
        
        // $orders = Order::trackable()->descOrder()
        //     ->whereHas('transaction', fn($transQ) => $transQ->customer($customerId))
        //     ->with([
        //         'products',
        //         'transaction' => fn($t) => $t->select('id', 'status')
        //     ])
        //     ->get();
        
          $transaction = Transaction::descOrder()->where('customer_id',$customerId)
           ->where('status', '!=', OrderStatus::COMPLETED)
           ->where('status', '!=', OrderStatus::CANCELED)
           ->where('status', '!=', OrderStatus::SHIPPING_DONE)
                // ->whereHas('transaction', fn($transQ) => $transQ->customer($customerId))
                ->with([
                'products',
                ])
             ->get();
        return [
            'success' => true,
            'status' => 200,
            'data' => OrderTrackingResource::collection($transaction),
            'message' => __('order.api.retrieved')
        ];
    }

    /**
     * @param $transactionId
     * @return array
     */
    public function getOrderDetails($transactionId) {
        $customerId = auth('api')->user()->id;
        $transaction = Transaction::query()->customer($customerId)->id($transactionId)
            ->with(['orders' => function ($q) {
                return $q->with([
                    'products' => fn($prodQ) => $prodQ->withTrashed(),
                    'transaction' => fn($t) => $t->select('id', 'status')
                ]);
            }])
            ->first();

        return [
            'success' => true,
            'status' => 200,
            'data' => new TransactionDeatailsResource($transaction),
            'message' => __('order.api.retrieved')
        ];
    }

    /**
     * @param $transactionId
     * @return array
     */
    public function getOrderDetailsForRate($transactionId) {
        $customerId = auth('api')->user()->id;
        $transaction = Transaction::query()->customer($customerId)->id($transactionId)
            ->statuses([OrderStatus::COMPLETED ,OrderStatus::REFUND])
            ->with([
                'orders' => fn($orderQuery) => $orderQuery->with([
                    'vendor' => fn($vendorQuery) => $vendorQuery->with([
                        'userVendorRates' => fn($rateQuery) => $rateQuery->where('user_id', $customerId)->where('transaction_id', $transactionId)
                    ])
                    ->withTrashed(),
                    'products' => fn($productsQuery) => $productsQuery->with([
                        'reviews' => fn($reviewsQuery) => $reviewsQuery->where('user_id', $customerId)->where('transaction_id', $transactionId)
                    ])
                    ->withTrashed()
                ])
            ])
            ->first();
        
        if($transaction == null ){
            return [
                'success' => false,
                'status' => 404,
                'data' => [],
                'message' => __('order.api.order_not_found')
            ];
        }
        return [
            'success' => true,
            'status' => 200,
            'data' =>  new TransactionForRateResource($transaction),
            'message' => __('order.api.retrieved')
        ];
    }
}