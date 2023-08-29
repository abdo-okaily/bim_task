<?php

namespace App\Services\Api;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Models\Transaction;
use App\Events\Transaction as TransactionEvents;
use App\Exceptions\Transactions\Addresses\AddressIsInternational;
use App\Exceptions\Transactions\PlaceOrderBusinessException;
use Illuminate\Http\Request;
use App\Repositories\Api\CartRepository;
use App\Http\Requests\Api\TransactionRateStore;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Coupon;
use App\Models\OnlinePayment;
use App\Services\Order\PlaceOrder;
use App\Services\Order\PlaceOrderBuilder;
use App\Services\Payments\Urway\UrwayServices;
use App\Services\Payments\Urway\Constants as UrwayConstants;
use Illuminate\Http\RedirectResponse;

class TransactionService
{
    private int $customerId;

    /**
     * @param CartRepository $cartRepository
     */
    public function __construct(public CartRepository $cartRepository) {}

    /**
     * @return self
     */ 
    public function setCustomerId($customerId) : self{
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @param int $transactionId
     * @param TransactionRateStore $request
     * @return array
     */
    public function saveOrderRate(int $transactionId, TransactionRateStore $request) {
      
        $transaction = Transaction::query()
            ->customer($this->customerId)
            ->id($transactionId)
            ->statuses([OrderStatus::COMPLETED ,OrderStatus::REFUND])
            ->with([
                'orders' => fn($orderQuery) => $orderQuery->with([
                    'vendor' => fn($vendorQuery) => $vendorQuery->with([
                        'userVendorRates' => fn($rateQuery) => $rateQuery->where('user_id', $this->customerId)->where('transaction_id', $transactionId)
                    ]),
                    'products' => fn($productsQuery) => $productsQuery->with([
                        'reviews' => fn($reviewsQuery) => $reviewsQuery->where('user_id', $this->customerId)->where('transaction_id', $transactionId)
                    ])
                ])
            ])
            ->first();
           
        if($transaction == null) {
            return [
                'success' => false,
                'status' => 404,
                'data' => [],
                'message' => __('order.api.order_not_found')
            ];
        }
        
        foreach($request->vendors as $vendorData) {
            $order = $transaction->orders->where('vendor_id', $vendorData['id'])->first();
            if (!$order) continue; // ignore non exists orders

            $vendor = $order->vendor; 

            // add rate to vendor in case customer doesn't rate the vendor in this transaction
            if($vendor->userVendorRates->isEmpty() && $vendorData['rate']) {
                $vendor->userVendorRates()->create([
                    'user_id' => $this->customerId,
                    'rate' => $vendorData['rate'],
                    'transaction_id' => $transactionId
                ]);
            }

            foreach($vendorData['products'] as $productData) {
                $productOrder = $order->products->where('id', $productData['id'])->first();

                if (!$productOrder || (!$productData['rate'] && !isset($productData['review'])) ) continue; // ignore non exists products
                if($productOrder->reviews->isEmpty()) {
                    $productOrder->reviews()->create([
                        'user_id' => $this->customerId,
                        'rate' => $productData['rate'],
                        'comment' => $productData['review'] ?? "",
                        'transaction_id' => $transactionId
                    ]);
                }
            }
        } 

        return [
            'success' => true,
            'status' => 200 ,
            'data' => [],
            'message' => __('products.api.product_review_created')
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function generatePaymentRequest(Request $request) : array {
        $cart = $this->cartRepository->curretUserAvtiveCart($this->customerId);
        if (!$cart) throw new PlaceOrderBusinessException(__("cart.api.cart_is_empty"));
        $cartId = $cart->id;
        $cartBaseModel = clone $cart;
        $customer = $cart->user;
        $builder = $this->getPlaceOrderBuilder($request)->setCart($cart);
        
        return PlaceOrder::createPlaceOrderProcess($builder->build(), $customer)
            ->setUsingWallet($request->get("use_wallet") == 1)
            ->setPaymentMethod(PaymentMethods::VISA)
            ->saveTransaction()
            ->successCallback(fn() => $this->deleteCart($cartId, $customer->id))
            ->failureCallback(function() use ($cartBaseModel) {
                $this->cartRepository->update(['is_active' => 1], $cartBaseModel);
            })
            ->toArray();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function paymentCallback(Request $request) : RedirectResponse {
        $transaction = Transaction::find($request->TrackId);
        
        if ($transaction && UrwayServices::paymentCallback($request)->isSuccess()) {
            $transaction->update(['status' => OrderStatus::PAID]);
            OnlinePayment::create([
                'customer_id' => $transaction->customer_id,
                'amount' => $request->amount,
                'currency' => UrwayConstants::currency,
                'payment_method' => $request->cardBrand,
                'payment_id' => $request->PaymentId,
                'transaction_id' => $transaction->id,
            ]);
            event(new TransactionEvents\Created($transaction));
            return redirect()->away($this->afterPaymentSuccessRedirectUrl());
        } else if ($transaction && $transaction->status == OrderStatus::REGISTERD) {
            $transaction->update(['status' => OrderStatus::CANCELED]);
            event(new TransactionEvents\Cancelled($transaction->load("orders.vendor.wallet.transactions")));
        }
        return redirect()->away($this->afterPaymentFailRedirectUrl());
    }

    /** 
     * @return string
     */
    public function afterPaymentSuccessRedirectUrl() : string {
        $lang_parameter    = (request()->UserField4 && request()->UserField4 == 'en') ? 'en/' : '';
        return  env('PAYMENT_SUCESS_URL') . $lang_parameter . '?payment=sucess';
    }
    
    /**
     * @return string
     */
    public function afterPaymentFailRedirectUrl() : string{
        $lang_parameter    = (request()->UserField4 && request()->UserField4 == 'en') ? 'en/' : '';
        return  env('PAYMENT_SUCESS_URL') . $lang_parameter . '?payment=fail';
    }

    /**
     * @param Request $request
     * @return array
     */
    public function cashCheckout(Request $request) : array {
        $cart = $this->cartRepository->curretUserAvtiveCart($this->customerId);
        if (!$cart) throw new PlaceOrderBusinessException(__("cart.api.cart_is_empty"));
        $cartId = $cart->id;
        $customer = $cart->user;
        //TODO: to be removed  
        if(Address::find($request->address_id)->is_international == 1){
            throw new AddressIsInternational();    
        }   

        $builder = $this->getPlaceOrderBuilder($request)->setCart($cart);

        $transactionResponse = PlaceOrder::createPlaceOrderProcess($builder->build(), $customer)
            ->setUsingWallet($request->get("use_wallet") == 1)
            ->setPaymentMethod(PaymentMethods::CASH)
            ->saveTransaction();
        
        event(new TransactionEvents\Created($transactionResponse->getTransaction()));
        return $transactionResponse->successCallback(fn() => $this->deleteCart($cartId, $customer->id))->toArray();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function walletCheckout(Request $request) : array {
        $cart = $this->cartRepository->curretUserAvtiveCart($this->customerId);
        if (!$cart) throw new PlaceOrderBusinessException(__("cart.api.cart_is_empty"));
        $cartId = $cart->id;
        $customer = $cart->user;
        $builder = $this->getPlaceOrderBuilder($request)->setCart($cart);

        $transactionResponse = PlaceOrder::createPlaceOrderProcess($builder->build(), $customer)
            ->setUsingWallet(true)
            ->setPaymentMethod(PaymentMethods::WALLET)
            ->saveTransaction();
        
        event(new TransactionEvents\Created($transactionResponse->getTransaction()));
        return $transactionResponse->successCallback(fn() => $this->deleteCart($cartId, $customer->id))->toArray();
    }

    /**
     * @param int $cartId
     * @param ?int $customerId
     * @return void
     */
    private function deleteCart(int $cartId, int $customerId = null) : void {
        CartProduct::where('cart_id', $cartId)->delete();
        Cart::when(!$customerId, fn($q) => $q->where('id', $cartId))
            ->when($customerId, fn($q) => $q->where('user_id', $customerId))->forceDelete();
    }

    /**
     * @param Request $request
     * @return PlaceOrderBuilder
     */
    private function getPlaceOrderBuilder(Request $request) : PlaceOrderBuilder {
        $address = $request->get('address_id') ? Address::find($request->get('address_id')) : null;
        $coupon = $request->get('coupon_code') ? Coupon::where("code", $request->get("coupon_code"))->first() : null;
        
        $builder = PlaceOrderBuilder::create();
        
        if ($coupon) $builder = $builder->setCoupon($coupon);
        if ($address) $builder = $builder->setAddress($address);

        return $builder;
    }
}
