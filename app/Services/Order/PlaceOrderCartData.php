<?php
namespace App\Services\Order;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Services\Order\Contracts\CartDataInterface;
use Exception;

class PlaceOrderCartData implements CartDataInterface {
    private Cart $cart;
    private Address $address;
    private Coupon $coupon;
    
    public function __construct(Cart $cart, Address $address) {
        $this->cart = $cart->load([
            'vendors' => fn($vendorQuery) => $vendorQuery->select('vendors.id', 'vendors.name', 'vendors.commission')
                ->groupBy('vendors.id', 'vendors.name', 'vendors.commission', 'cart_product.cart_id', 'cart_product.vendor_id')
                ->with([
                    'cartProducts' => fn($cartProductQuery) => $cartProductQuery->where('cart_product.cart_id', $cart->id)->withTrashed()->with('prices')
                ]),
            'cartProducts.product.prices'
        ]);
        $this->address = $address->load("city");
    }

    public function getCart() : Cart {
        return $this->cart;
    }

    public function getAddress() : Address {
        return $this->address;
    }

    public function getProductsCount() : int {
        return $this->cart->products->count() ?? 0;
    }

    public function isProductsAvailable() : bool {
        try {
            $productCount = $this->getProductsCount();
            $availableProductCount = $this->cart->cartProducts->filter(fn($cartProduct) => $cartProduct->product->is_available_product)->count();
            return $availableProductCount == $productCount;
        } catch (Exception $e) {
            return false;
        }
    }


    public function isProductsHasStock() : bool {
        return $this->cart->cartProducts->filter(fn($cartProduct) => $cartProduct->quantity > $cartProduct->product->stock)->isEmpty();
    }

    public function isCartEmpty() : bool {
        return $this->cart->vendors->count() <= 0;
    }

    public function cartTotalPrices() : float {
        // TODO: international sales
        return $this->cart->cartProducts->sum(function($cartProduct) {
            // Apply 15 vat according to current vat in Saudi Arabia (it must be ignored when activate international sales)
            // the next line must be removed when apply product price model to all exists products
            $productPriceWithoutVat = $cartProduct->product->price * 1 / 1.15;

            // TODO: must be replaced with country price after apply international sales
            if ($productPrice = $cartProduct->product->prices->first()) {
                $productPriceWithoutVat = $productPrice->price_without_vat_in_halala;
            }

            return $cartProduct->quantity * $productPriceWithoutVat;
        });
    }

    public function getDeliveryFees() : float {
        // TODO: need to be refactored according to new business for domestic zone
        return 0;
        // return ($this->getAddress()->city->domesticZones->torodCompany->delivery_fees ?? 0) * 100;
        // return ($this->getAddress()->city->domesticZones->delivery_fees ?? 0) * 100;
    }

    public function setCoupon(Coupon $coupon) : CartDataInterface {
        $this->coupon = $coupon;
        return $this;
    }

    public function getCoupon() : Coupon | null {
        return isset($this->coupon) ? $this->coupon : null;
    }
}