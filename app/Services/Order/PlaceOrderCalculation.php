<?php
namespace App\Services\Order;

use App\Enums\CouponType;
use App\Enums\SettingEnum;
use App\Models\Country;
use App\Models\Setting;
use App\Services\Order\Contracts\CartDataInterface;
use App\Services\Order\Contracts\PlaceOrderCalculationInterface;
use App\Services\Order\Contracts\PlaceOrderDataInterface;
use Exception;

class PlaceOrderCalculation implements PlaceOrderCalculationInterface {
    private float $vat;
    private float $subTotal;
    private float $vatRate;
    private float $deliveryFees;
    private float $discount;
    private float $total;
    private float $vatPercentage;

    /**
     * @param CartDataInterface $cartData
     */
    public function __construct(private CartDataInterface $cartData) {
        // TODO: international sales
        // TODO: workarround till apply international sales
        $country = Country::where(fn($q) => $q->where('code', 'sa')->where('code', 'SA'))->first();
        $vatPercentage = $country ? $country->vat_percentage : (Setting::where('key', SettingEnum::vat)->first()->value ?? 0);
        
        $this->vatPercentage = $vatPercentage;
        $this->setCalculations($this->cartData->cartTotalPrices());
    }

    /**
     * @param float $deliveryFees
     * @return self
     */
    public function setDeliveryFees(float $deliveryFees) : self {
        $this->deliveryFees = $deliveryFees;
        return $this;
    }

    /**
     * @param float $total
     * @return self
     */
    public function setTotal(float $total) : self {
        $this->setCalculations($total);
        return $this;
    }

    /**
     * @return PlaceOrderDataInterface
     */
    public function calculate() : PlaceOrderDataInterface {
        return (new PlaceOrderData($this->cartData))->setTotals($this);
    }

    /** @return float */
    public function getTotalVat() : float {return $this->vatRate;}

    /** @return float */
    public function getSubTotal() : float {return $this->subTotal;}

    /** @return float */
    public function getTotal() : float {return $this->total;}

    /** @return float */
    public function getTotalWithoutVat() : float {return $this->subTotal;}

    /** @return float */
    public function getVatRate() : float {return $this->vatRate;}

    /** @return float */
    public function getVatPercentage() : float {return $this->vatPercentage;}

    /** @return float */
    public function getDeliveryFees() : float {return $this->deliveryFees;}

    /** @return float */
    public function getDiscount() : float {return $this->discount;}

    /** @return array */
    public function getCalculationsInSr() : array {
        return [
            "sub_total" => $this->subTotal,
            "total" => $this->total,
            "total_vat" => $this->vatRate,
            "vat_rate" => $this->vatRate,
            "total_without_vat" => $this->subTotal,
            "delivery_fees" => $this->deliveryFees,
            "vat_percentage" => $this->vatPercentage,
            "discount" => $this->discount,
        ];
    }

    /**
     * @param float $total
     * @return void
     * */
    private function setCalculations(float $total) : void {
        $this->vat = $this->vatPercentage / 100;
        $this->total = $total;
        $this->subTotal = $this->total;
        $this->discount = 0;
        if ($coupon = $this->cartData->getCoupon()) {
            $totalPaidAmount = 0;
            if ($coupon->coupon_type == CouponType::GLOBAL) {
                $totalPaidAmount = $this->cartData->cartTotalPrices() + $this->cartData->getDeliveryFees();
            } else if ($coupon->coupon_type == CouponType::FREE) {
                $totalPaidAmount = $this->cartData->getDeliveryFees();
            }
            if ($totalPaidAmount > 0) {
                try {
                    $coupon->isValidToUse($totalPaidAmount);
                    if ($coupon->isExceedCustomerMaxUsage($this->cartData->getCart()->user_id)) {// customer exceed maximum limit
                        throw new Exception(__("cart.api.coupon-exceed-usage"));
                    }
                    $this->discount = $coupon->calculateDiscount($totalPaidAmount);
                } catch (Exception $e) {
                    // TODO: ,must not ignore exceptions
                }
            }
        }
        $this->deliveryFees = $this->cartData->getDeliveryFees();
        $this->vatRate = ($this->subTotal + $this->deliveryFees) * $this->vat;
    }
}