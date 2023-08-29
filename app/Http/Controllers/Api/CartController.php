<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Services\Api\CartService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\CartResource;
use Illuminate\Http\Request;
use App\Http\Requests\Api\DeleteCartProduct;
use App\Http\Requests\Api\EditCartProduct;
use App\Models\Address;

class CartController extends ApiController
{
    /**
     * @param CartService $service
     */
    public function __construct(public CartService $service) {
        $this->middleware('api.auth');
    }

    /**
     * @hint: useless function
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $carts = $this->service->getAllCartsWithPagination();
        return $this->setApiResponse(true, 200, CartResource::collection($carts),
        __('To-Do'));
    }

    /**
     * @hint: useless function
     * @param int $cart_id
     * @return JsonResponse
     */
    public function show(int $cart_id) : JsonResponse
    {
        $cart = $this->service->getCartUsingID($cart_id);
        return $this->setApiResponse(true, 200, new CartResource($cart),
            __('To-Do'));
    }

    /**
     * @param EditCartProduct $request
     * @return JsonResponse
     */
    public function addOrEditProduct(EditCartProduct $request) : JsonResponse
    {
        $response = $this->service->editCart($request, auth('api')->user()->id);
        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function syncCartWithLocal(Request $request) : JsonResponse
    {
        $response = $this->service->syncCart($request->cart, auth('api')->user()->id);
        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }


    
    /**
     * @param int $transaction_id
     * @return JsonResponse
     */
    public function reorder(int $transaction_id) : JsonResponse
    {
        $response = $this->service->fillCartWithPreviousOrder($transaction_id, auth('api')->user()->id);

        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    /**
     * @return JsonResponse
     */
    public function getVendorProducts() : JsonResponse
    {
        $addres_id = Address::where("user_id", auth("api")->id())->default()->first()->id ?? null;
        if ($addres_id) request()->merge(['mergedAddressId' => $addres_id]);
        $response = $this->service->getCartProductGroupedByVendor(auth('api')->user()->id);
        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
    
    /**
     * @return JsonResponse
     */
    public function summary() : JsonResponse
    {
        if (request()->has('address_id')) request()->merge(['mergedAddressId' => request()->get('address_id')]);
        if (request()->has('coupon_code')) request()->merge(['mergedCouponCode' => request()->get('coupon_code')]);
        $response = $this->service->getCartProductGroupedByVendor(auth('api')->user()->id);
        $responseData = [
            "success" => $response['success'],
            "status" => $response['status'],
            "message" => $response['message'],
        ];
        if (isset($response['coupon_message'])) $responseData['coupon_message'] = $response['coupon_message'];
        if (isset($response['address_message'])) $responseData['address_message'] = $response['address_message'];
        
        $responseData["data"] = $response['data'];
        return new JsonResponse($responseData, $response['status']);
    }

    /**
     * @param DeleteCartProduct $request
     * @return JsonResponse
     */
    public function deleteProduct(DeleteCartProduct $request) : JsonResponse
    {
        $response = $this->service->deleteProductFromCart($request->product_id, auth('api')->user()->id);
        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
}
