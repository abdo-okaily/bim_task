<?php
namespace App\Services\Order;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;
use App\Services\Order\Contracts\CartDataInterface;
use App\Services\Order\Contracts\PlaceOrderCalculationInterface;
use App\Services\Order\Contracts\PlaceOrderDataInterface;
use App\Services\Order\Contracts\PlaceOrderTransactionInterface;

class PlaceOrderData implements PlaceOrderDataInterface {
    private CartDataInterface $cartData;
    private Cart $cart;
    private User $customer;
    
    public function __construct(CartDataInterface $cartData) {
        $this->cartData = $cartData;
        $this->cart = $this->cartData->getCart();
    }

    public function setCustomer(User $customer) : PlaceOrderDataInterface {
        $this->customer = $customer->load('ownWallet');
        return $this;
    }

    public function getCustomer() : User {
        return $this->customer;
    }

    public function getCart() : Cart {
        return $this->cart;
    }

    public function getAddress() : Address {
        return $this->cartData->getAddress();
    }

    public function setTotals(PlaceOrderCalculationInterface $placeOrderCalculation) : PlaceOrderDataInterface {
        $this->cart->totals = [
            "total_vat" => $placeOrderCalculation->getVatRate(),
            "sub_total" => $placeOrderCalculation->getSubTotal(),
            "total" => $placeOrderCalculation->getTotal(),
            "total_without_vat" => $placeOrderCalculation->getTotalWithoutVat(),
            "vat_rate" => $placeOrderCalculation->getVatRate(),
            "vat_percentage" => $placeOrderCalculation->getVatPercentage(),
            "delivery_fees" => $placeOrderCalculation->getDeliveryFees(),
            "discount" => $placeOrderCalculation->getDiscount(),
        ];

        $this->cart->vendors = $this->cart->vendors->map(function ($vendor) use ($placeOrderCalculation) {
            // TODO: international sales
            $vendorTotal = $vendor->cartProducts->sum(function($product) {
                // Apply 15 vat according to current vat in Saudi Arabia (it must be ignored when activate international sales)
                // the next line must be removed when apply product price model to all exists products
                $productPriceWithoutVat = $product->price * 1 / 1.15;
    
                // TODO: must be replaced with country price after apply international sales
                if ($productPrice = $product->prices->first()) {
                    $productPriceWithoutVat = $productPrice->price_without_vat_in_halala;
                }
    
                return $product->pivot->quantity * $productPriceWithoutVat;
            });
            $placeOrderCalculation = $placeOrderCalculation->setTotal($vendorTotal);
            $vendorTotals = [
                "total_vat" => $placeOrderCalculation->getVatRate(),
                "sub_total" => $placeOrderCalculation->getSubTotal(),
                "total" => $placeOrderCalculation->getTotal(),
                "total_without_vat" => $placeOrderCalculation->getTotalWithoutVat(),
                "vat_rate" => $placeOrderCalculation->getVatRate(),
                "vat_percentage" => $placeOrderCalculation->getVatPercentage(),
                "delivery_fees" => $placeOrderCalculation->getDeliveryFees(),
                "discount" => $placeOrderCalculation->getDiscount(),
            ];

            $vendorCommission = $vendor->commission ?? 10;

            $companyProfit = $this->calulateCompanyProfit(
                $vendorCommission, $vendorTotals['sub_total'] ?? 0, $vendorTotals['vat_percentage'] ?? 0
            );

            $orderTotal = ($vendorTotals['sub_total'] ?? 0) + ($vendorTotals['vat_rate'] ?? 0);
            $vendor->totals = array_merge([
                'company_percentage' => $vendorCommission,
                'company_profit' => $companyProfit,
                'vendor_amount' => $orderTotal - $companyProfit,
            ], $vendorTotals);
            return $vendor;
        });
        return $this;
    }

    public function getTotalAmount() : float {
        return $this->cart->totals['total'] +
            $this->cart->totals['vat_rate'] +
            $this->cart->totals['delivery_fees'] -
            $this->cart->totals['discount'];
    }

    public function getProductsCount() : int {
        return $this->cartData->getProductsCount();
    }

    public function makeTransaction() : PlaceOrderTransactionInterface {
        return new PlaceOrderTransaction($this);
    }

    public function getCoupon() : Coupon | null {
        return $this->cartData->getCoupon();
    }

    /**
     * @param float $vendorCommission
     * @param float $subTotal
     * @param float $vatPercentage
     * @return float
     */
    private function calulateCompanyProfit(
        float $vendorCommission,
        float $subTotal,
        float $vatPercentage
    ) : float {
        return ($vendorCommission * $subTotal / 100) * (1 + ($vatPercentage / 100));
    }
}