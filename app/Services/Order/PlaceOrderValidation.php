<?php
namespace App\Services\Order;

use App\Enums\CouponType;
use App\Exceptions\Transactions\PlaceOrderBusinessException;
use App\Http\Resources\Api\CartResource;
use App\Services\Order\Contracts\CartDataInterface;
use App\Services\Order\Contracts\PlaceOrderCalculationInterface;
use App\Services\Order\Contracts\PlaceOrderValidationsInterface;
use Exception;

class PlaceOrderValidation implements PlaceOrderValidationsInterface {
    private CartDataInterface $cartData;
    private $validationMessages = [];
    private string $couponMessage = '';
    private string $addressMessage = '';
    private string $cartMessage = '';

    public function __construct(CartDataInterface $cartData) {
        $this->cartData = $cartData;
    }

    /**
     * @return PlaceOrderCalculationInterface
     * @throws PlaceOrderBusinessException
     */
    public function validate() : PlaceOrderCalculationInterface {
        $this->validateCart();
        $this->validateAddress();
        $this->validateCoupon();
        if (
            $this->couponMessage || $this->addressMessage || $this->cartMessage
        ) {
            $this->throwBusinessExceptions(__('cart.api.cart_wrong'), [
                'coupon_message' => $this->couponMessage,
                'address_message' => $this->addressMessage,
                'message' => $this->cartMessage ? $this->cartMessage : __('cart.api.cart_wrong'),
            ]);
        }
        return new PlaceOrderCalculation($this->cartData);
    }

    /**
     * @return void
     */
    private function validateAddress() : void {
        // TODO: need to be refactored
        // just ignore empty address from validation, its just a workarround
        $address = $this->cartData->getAddress();
        if (!$address->id) return;
        if(
            $address &&
            $address->city && $address->city->is_active
            // $address->city->domesticZones && $address->city->domesticZones->delivery_fees
            // $address->city->domesticZones->torodCompany && $address->city->domesticZones->torodCompany->torod_courier_id
        ) {
            return;
        }
        $this->addressMessage  = __("cart.api.address-out-of-coverage");
    }

    /**
     * @return void
     */
    private function validateCart() : void {
        if ($this->cartData->isCartEmpty())
            $this->cartMessage = __("cart.api.cart_is_empty");
        if (!$this->cartData->isProductsAvailable())
            $this->cartMessage = __("cart.api.cannot_checkout_product_missing");
        if (!$this->cartData->isProductsHasStock())
            $this->cartMessage = __("cart.api.cannot_checkout_product_missing");
    }

    /**
     * @return void
     */
    private function validateCoupon() : void {
        if ($coupon = $this->cartData->getCoupon()) {
            try {
                $totalInHalala = 0;
                if ($coupon->coupon_type == CouponType::GLOBAL) {
                    $totalInHalala = $this->cartData->cartTotalPrices() + $this->cartData->getDeliveryFees();
                } else if ($coupon->coupon_type == CouponType::FREE) {
                    $totalInHalala = $this->cartData->getDeliveryFees();
                }
                $coupon->isValidToUse($totalInHalala);
            } catch (Exception $e) {
                $this->couponMessage = $e->getMessage();
            }

            if ($coupon->isExceedCustomerMaxUsage($this->cartData->getCart()->user_id)) {// customer exceed maximum limit
                $this->couponMessage = __("cart.api.coupon-exceed-usage");
            }

            if (
                !isset($this->validationMessages['address_message'])
            ) $this->validationMessages['address_message'] = '';
        }
    }

    /**
     * @param string $msg
     * @param array $messages
     * @throws PlaceOrderBusinessException
     */
    private function throwBusinessExceptions(string $msg, array $messages) {
        $cartCalculation = new PlaceOrderCalculation($this->cartData);
        $cart = $cartCalculation->calculate()->getCart();
        $cart->wallet_amount = $cart?->user?->ownWallet?->amount_with_sar ?? 0;

        throw (new PlaceOrderBusinessException($msg))
            ->setCartResource(new CartResource($cart))
            ->setMessages($messages);
    }
}