<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Services\Api\SearchService;
use Illuminate\Support\Facades\App;

class SearchController extends ApiController
{
    /**
     * Address Controller Constructor.
     *
     * @param AddressService $service
     */
    public function __construct(public SearchService $service) {
    }

    /**
     * .
     *
     * @param url query parameters
     * @return JsonResponse
     */
    public function globalSearch() 
    {
        $parameter = request()->q ?? '';
        $response = $this->service->globalSearch($parameter);
        // return($parameter);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
}
