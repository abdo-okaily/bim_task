<?php

namespace App\Services\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Repositories\Api\CartRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Api\CartResource;
use App\Models\CartProduct;
use App\Repositories\Api\TransactionRepository;
use App\Services\Order\PlaceOrder;
use Closure;
use Illuminate\Http\Response;

class CartService
{
    /**
     * Cart Service Constructor.
     *
     * @param CartRepository $repository
     */
    public function __construct(
        public CartRepository $repository,
        public TransactionRepository $transactionRepository,
        public VendorService $vendorService,
        public ProductService $productService,
        public AddressService $addressService,
    ) {}

    /**
     * Get carts.
     *
     * @return Collection
     */
    public function getAllcarts() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Categories with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllCartsWithPagination(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->repository->all()->paginate($perPage);
    }

    /**
     * Get Cart using ID.
     *
     * @param integer $id
     * @return Cart
     */
    public function getCartUsingID(int $id) : Cart|null
    {
        return $this->repository->getModelUsingID($id);
    }

    /**
     * @param Request $request
     * @param integer $customerId
     * @return array
     */
    public function editCart(Request $request, int $customerId) : array
    {
        $cart = $this->getCurrentUserActiveCartOrCreate($customerId);
        $handled = $this->handleCardProductChange($request->toArray(),$cart);
        
        if ($handled === false) {
            return [
                'success' => false,
                'status' => Response::HTTP_NOT_ACCEPTABLE,
                'data' => [],
                'message'=>__('cart.api.cannot_checkout_product_missing')
            ];
        }

        return $this->getCartProductGroupedByVendor($customerId, function () use ($cart) {
            return PlaceOrder::createPlaceOrderCalculation($cart)->getCalculationsInSr();
        });
    }

    /**
     * @param array $LocalCartProducts
     * @param integer $customerId
     * @return void
     */
    public function syncCart(array $LocalCartProducts, int $customerId)
    {
        $cart = $this->getCurrentUserActiveCartOrCreate($customerId);
        $missingProducts = false;
        foreach($LocalCartProducts as $product) {
            $handled = $this->handleCardProductChange($product,$cart);
            if($handled === false) $missingProducts =true;
        }
        $cartRersponse = $this->getCartProductGroupedByVendor($customerId);
        if($missingProducts) $cartRersponse['message'] = __('cart.api.cart_updated_with_missings');

        return $cartRersponse;
    }

    /**
     * @param integer $customerId
     * @return Cart
     */
    public function getCurrentUserActiveCartOrCreate(int $customerId) : Cart
    {
        return $this->repository->curretUserAvtiveCart($customerId);
    }

    /**
     * @param array $request
     * @param Model $cart
     * @param boolean $append
     * @return boolean|null
     */
    public function handleCardProductChange(array $request, Model $cart, bool $append = false) : bool|null {
        $cartProduct = $cart->cartProducts()->where('product_id',$request['product_id'])->first();

        $product = $request['product'] ?? $this->productService->repository->getProductIfAvailableWithQuantity($request['product_id'],$request['quantity']);
        if(!$product) return false;

        if ($product->is_not_available_product) return false;

        if($cartProduct == null) return $this->_addProductToCart($request, $cart, $product->vendor_id);
        
        return $this->_editProductInCart($request, $cartProduct,$cart->id ,$product->vendor_id,$append);
    }

    /**
     * @param integer $customerId
     * @return array
     */
    public function getCartProductGroupedByVendor(int $customerId, Closure $totalsCalculation = null) : array {
        $cart =  $this->repository->curretUserAvtiveCart($customerId);
        if ($cart == null) return ['success' => true, 'status' => 200, 'data' => [], 'message'=> __('cart.api.cart_is_empty')];

        $cartId = $cart->id;
        $cart = Cart::query()->where('id', $cartId)->with([
            'vendors' => function ($vendorQuery) use ($cartId) {
                $vendorQuery->select('vendors.id','vendors.name')
                ->groupBy('vendors.id', 'vendors.name', 'cart_product.cart_id', 'cart_product.vendor_id')
                ->with([
                    'cartProducts' => fn ($q) => $q->where('cart_product.cart_id', $cartId)->withTrashed()
                ]);
            },
            'user.ownWallet'
        ])
        ->withSum('cartProducts','quantity')
        ->first();

        if($cart === null || (!$cart->vendors->count())) {
            return [
                'success'=>true,
                'status'=>200 ,
                'data'=>[],
                'message'=>__('cart.api.cart_is_empty')
            ];
        }
        $customer = $cart->user;
        $cart['totals'] = $totalsCalculation ? $totalsCalculation() : PlaceOrder::createPlaceOrderData(
            $cart, request()->get('mergedAddressId'), request()->get('mergedCouponCode')
        )
        ->getCalculationsInSr();
        $cart['wallet_amount'] = $customer->ownWallet->amount_with_sar ?? 0;

        $response = [
            'success'=>true,
            'status'=>200 ,
            'data'=>new CartResource($cart),
            'message'=>__('cart.api.cart_updated')
        ];
        
        if (isset($cart['totals']['discount']) && $cart['totals']['discount'] > 0) {
            $response["coupon_message"] = __("cart.api.coupon-applied");
        }

        if (isset($cart['totals']['delivery_fees']) ) {   //TODO: you may need to add this: && $cart['totals']['delivery_fees'] > 0
            $response["address_message"] = __("cart.api.address-selected");
        }

        return $response;
    }

    /**
     * @param integer $transaction_id
     * @param integer $customerId
     * @return array
     */
    public function fillCartWithPreviousOrder(int $transaction_id, int $customerId) : array {
        $transaction = $this->transactionRepository->getModelUsingID($transaction_id);

        if($transaction == null || $transaction->status != 'completed') {
            return [
                'success' => false,
                'status' => 400 ,
                'data' => [],
                'message' => __('cart.api.cannot_reorder')
            ];
        }
        $productCount = 0;

        $orders = $transaction->orders()->with(['products' => fn($q) => $q->available(), 'vendor' => fn($q) => $q->available()])->get();

        $cart = $this->getCurrentUserActiveCartOrCreate($customerId);
        foreach($orders as $order) {
            foreach($order->products as $product) {
                $data = [
                    'quantity' => $product->pivot->quantity,
                    'product_id'=>$product->id,
                    'product' =>$product
                ];
                $handled = $this->handleCardProductChange($data,$cart,true);
                if($handled) $productCount += ($product->pivot->quantity);
            }
        }
        $message= __('cart.api.reorder_successfully');
        $isSuccess = true;
        $statusCode = 200;
        $cartData = [];
        if($productCount == 0 || $productCount != $transaction->products_count) {
            $message= __('cart.api.cannot_reorder');
            $isSuccess = false;
            $statusCode = 400;
            $cart->cartProducts()->delete();
            $cart->forceDelete();
        } else {
            $cartData = $this->getCartProductGroupedByVendor($customerId)['data'];
        }
        $cartRersponse['data'] = $cartData;
        $cartRersponse['message'] = $message;
        $cartRersponse['success'] = $isSuccess;
        $cartRersponse['status']  = $statusCode;
        return $cartRersponse;
    }

    /**
     * @param integer $product_id
     * @param integer $customerId
     * @return array
     */
    public function deleteProductFromCart(int $product_id, int $customerId) : array {
        $cart =  $this->repository->curretUserAvtiveCart($customerId);
        if($cart) $cart->cartProducts()->where('product_id',$product_id)->delete();

        return $this->getCartProductGroupedByVendor($customerId, function () use ($cart) {
            return PlaceOrder::createPlaceOrderCalculation(
                $cart, request()->get('mergedAddressId'), request()->get('mergedCouponCode')
            )
            ->getCalculationsInSr();
        });
    }

    /**
     * @param array $request
     * @param Cart $cart
     * @param integer $vendor_id
     * @return bool|null
     */
    private function _addProductToCart(array $request, Cart $cart, int $vendor_id) : bool|null {
        if($cart == null||$request['quantity'] < 1) return null;
        $cartProduct = $this->repository->createCartProduct($cart,[
            'cart_id' => $cart->id,
            'quantity' => $request['quantity'],
            'vendor_id' => $vendor_id,
            'product_id' => $request['product_id'],
        ]);

        if($cartProduct) return true;
        return false;
    }

    /**
     * @param array $request
     * @param CartProduct $cartProduct
     * @param integer $cart_id
     * @param integer $vendor_id
     * @param boolean $append
     * @return bool
     */
    private function _editProductInCart(
        array $request,
        CartProduct $cartProduct,
        int $cart_id,
        int $vendor_id,
        bool $append = false
    ) : bool {
        if($request['quantity'] < 1) return $cartProduct->delete();
        else {
            $quantity =$request['quantity'];
            if($append) $quantity+= $cartProduct->quantity;
            
            $cartProduct = $this->repository->editCartProduct($cartProduct,[
                'cart_id'=>$cart_id,
                'quantity'=>$quantity,
                'product_id'=>$request['product_id'],
                'vendor_id'=>$vendor_id
            ]);
            return true;
        }
    }

    /**
     * @param Cart $cart
     * @hint: useless function
     * @return boolean
     */
    public function checkCartProductAvailabilty(Cart $cart) : bool {
        $available = true;
        
        $cartProducts = $cart->cartProducts()->get()->pluck('vendor_id','product_id')->toArray();

        $vendors_ids = array_unique($cartProducts);
        $products_ids = array_keys($cartProducts);
        foreach($vendors_ids as $id) {
            $available = $this->vendorService->checkAvilablity($id);
            if(! $available) return false;
        }

        foreach($products_ids as $id) {
            $available = $this->productService->checkAvilablity($id);
            if(! $available) return false;
        }
        return true;
    }
}
