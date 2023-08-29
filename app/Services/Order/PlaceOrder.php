<?php
namespace App\Services\Order;

use App\Enums\PaymentMethods;
use App\Exceptions\Transactions\PlaceOrderBusinessException;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Order\Contracts\CartDataInterface;
use App\Services\Order\Contracts\PlaceOrderCalculationInterface;
use App\Services\Order\Contracts\PlaceOrderResponseInterface;
use App\Services\Order\Contracts\PlaceOrderTransactionInterface;
use App\Services\Order\Contracts\PlaceOrderValidationsInterface;
use App\Services\Order\PaymentResponses\CashResponse;
use App\Services\Order\PaymentResponses\VisaResponse;
use App\Services\Order\PaymentResponses\WalletResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PlaceOrder {
    /**
     * @param CartDataInterface $cartDataInterface
     * @param User $customer
     * @return PlaceOrderTransactionInterface
     * @throws PlaceOrderBusinessException
     */
    public static function createPlaceOrderProcess(
        CartDataInterface $cartDataInterface, User $customer
    ) : PlaceOrderTransactionInterface {
        return self::createPlaceOrderValidation($cartDataInterface)
            ->validate()
            ->calculate()
            ->setCustomer($customer)
            ->makeTransaction();
    }

    /**
     * @param Transaction $transaction
     * @param int $paymentMethod
     * @return PlaceOrderResponseInterface
     * @throws Exception
     */
    public static function getPaymentResponse(
        Transaction $transaction,
        int $paymentMethod
    ) : PlaceOrderResponseInterface {
        switch($paymentMethod) {
            case PaymentMethods::VISA:
                return new VisaResponse($transaction);
            case PaymentMethods::CASH:
                return new CashResponse($transaction);
            case PaymentMethods::WALLET:
                return new WalletResponse($transaction);
        }
        throw new Exception("Please provide an implemented payment method");
    }

    /**
     * @param Cart $cart
     * @param int $addressId
     * @param string $couponCode
     * @return PlaceOrderCalculationInterface
     */
    public static function createPlaceOrderData(
        Cart $cart, int $addressId = null, string $couponCode = null
    ) : PlaceOrderCalculationInterface {
        $address = new Address();
        if ($addressId) {
            $address = Address::find($addressId);
            if (!$address) throw new ModelNotFoundException(__('cart.api.address-not-exists'));
        }
        $placeOrderBuilder = PlaceOrderBuilder::create();
        $placeOrderBuilder = $placeOrderBuilder->setAddress($addressId ? Address::findOrFail($addressId) : new Address());
        $placeOrderBuilder = $placeOrderBuilder->setCart($cart);

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if (!$coupon) throw new ModelNotFoundException(__('cart.api.coupon-not-exists'));
            $placeOrderBuilder = $placeOrderBuilder->setCoupon($coupon);
        }
        return self::createPlaceOrderDataWithValidation($placeOrderBuilder);
    }

    /**
     * TODO: need to be refactored
     * @param Cart $cart
     * @param int $addressId
     * @param string $couponCode
     * @return PlaceOrderCalculationInterface
     */
    public static function createPlaceOrderCalculation(
        Cart $cart, int $addressId = null, string $couponCode = null
    ) : PlaceOrderCalculationInterface {
        $address = new Address();
        if ($addressId) {
            $address = Address::find($addressId);
            if (!$address) throw new ModelNotFoundException(__('cart.api.address-not-exists'));
        }
        $placeOrderBuilder = PlaceOrderBuilder::create();
        $placeOrderBuilder = $placeOrderBuilder->setAddress($addressId ? Address::findOrFail($addressId) : new Address());
        $placeOrderBuilder = $placeOrderBuilder->setCart($cart);

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if (!$coupon) throw new ModelNotFoundException(__('cart.api.coupon-not-exists'));
            $placeOrderBuilder = $placeOrderBuilder->setCoupon($coupon);
        }
        return new PlaceOrderCalculation($placeOrderBuilder->build());
    }

    /**
     * @param PlaceOrderBuilder $builder
     * @return PlaceOrderCalculationInterface
     */
    private static function createPlaceOrderDataWithValidation(
        PlaceOrderBuilder $builder
    ) : PlaceOrderCalculationInterface {
        return (new PlaceOrderValidation($builder->build()))->validate();
    }

    private static function createPlaceOrderValidation(
        CartDataInterface $cartData
    ) : PlaceOrderValidationsInterface {
        return new PlaceOrderValidation($cartData);
    }
}