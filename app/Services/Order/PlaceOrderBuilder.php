<?php
namespace App\Services\Order;

use App\Exceptions\Transactions\PlaceOrderBusinessException;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Services\Order\Contracts\CartDataInterface;
use Exception;

class PlaceOrderBuilder {
    private Cart $cart;
    private Address $address;
    private Coupon $coupon;

    private function __construct() {}

    public static function create() : self {
        return new self();
    }

    public function setCart(Cart $cart) : self {
        $this->cart = $cart;
        return $this;
    }

    public function setAddress(Address $address) : self {
        $this->address = $address;
        return $this;
    }

    public function setCoupon(Coupon $coupon) : self {
        $this->coupon = $coupon;
        return $this;
    }

    public function build() : CartDataInterface {
        if (!isset($this->cart)) throw new PlaceOrderBusinessException(__('cart.api.cart_wrong'));
        if (!isset($this->address)) throw new PlaceOrderBusinessException(__('cart.api.address-not-exists'));

        $cartData = new PlaceOrderCartData($this->cart, $this->address);
        return isset($this->coupon) ? $cartData->setCoupon($this->coupon) : $cartData;
    }
}