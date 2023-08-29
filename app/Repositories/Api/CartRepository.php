<?php

namespace App\Repositories\Api;

use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Api\BaseRepository;

class CartRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Cart::class;
    }

    /**
     * @param integer $customerId
     * @return Cart
     */
    public function curretUserAvtiveCart(int $customerId) : Cart {
        $cart = Cart::where('user_id', $customerId)->withSum('cartProducts', 'quantity')->first();

        if (!$cart) $cart = Cart::create(['user_id' => $customerId, 'is_active' => 1]);
        else if ($cart->is_active != 1) $cart->update(['is_active' => 1]);

        return $cart;
    }

    public function createCartProduct(Model $cart,Array $cartProduct) : Model|bool
    {
        try {
            return $cart->cartProducts()->save(new CartProduct($cartProduct));
        } catch (\Illuminate\Database\QueryException $ex) {
            return false;
        }
    }

    /**
     * @param CartProduct $cartProduct
     * @param Array $data
     * @return Model|boolean
     */
    public function editCartProduct(CartProduct $cartProduct,Array $data) : Model|bool
    {
        try {
            $cartProduct->update( $data);
            return $cartProduct;
        } catch (\Illuminate\Database\QueryException $ex) {
            return false;
        }
    }

    /**
     * @param integer $product_id
     * @param integer $customerId
     * @return boolean
     */
    public function deleteCartProduct(int $product_id, int $customerId) : bool
    {
        try {
            $cart = $this->curretUserAvtiveCart($customerId);
            if($cart) return $cart->cartProducts()->where('product_id',$product_id)->delete();
        } catch (\Illuminate\Database\QueryException $ex) {
            return false;
        }
        return false;
    }
}
