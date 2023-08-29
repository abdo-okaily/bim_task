<?php
namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\CountryResource;
use Illuminate\Http\JsonResponse;
use App\Services\Api\AddressService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\AvailableMethodsRequest;
use App\Http\Resources\Api\ShippingMethodResource;
use App\Models\ShippingMethod;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ShippingMethodController extends ApiController
{
    /**
     * Shipping Method Controller Constructor.
     *
     */
    public function __construct() {
        $this->middleware('api.auth');
    }



    public function getAvailableMethods(AvailableMethodsRequest $request){

        $methods = ShippingMethodResource::collection(
            ShippingMethod::all()
        );
        
        return $this->setApiResponse
        (
            true,
            200,
            $methods ,
            __('api.shipping_methods.retrived')
        );
    }


}
