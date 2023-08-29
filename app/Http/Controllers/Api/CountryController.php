<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Services\Api\BlogPostService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ApiController;
use App\Services\Api\CountryService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CountryController extends ApiController
{
    /**
     * BlogPost Controller Constructor.
     *
     * @param BlogPostService $service
     */
    public function __construct(public CountryService $service) {}

    /**
     * List all BlogPosts.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $response = $this->service->getAllCountries();
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
        
    }

    /**
     * Get BlogPost using id.
     *
     * @param id $BlogPost_id
     * @return JsonResponse
     */
    public function show(int $BlogPost_id) : JsonResponse
    {
        $response = $this->service->getBlogPostUsingID($BlogPost_id);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
}
