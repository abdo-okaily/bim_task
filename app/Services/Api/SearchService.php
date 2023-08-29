<?php

namespace App\Services\Api;

use App\Http\Resources\Api\AddressResource;
use App\Http\Resources\Api\ProductResource;
use App\Models\Address;
use App\Repositories\Api\ProductRepository;
use Illuminate\Http\Request;
use App\Repositories\Api\ProductService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class SearchService
{
    /**
     * Address Service Constructor.
     *
     * @param ProductService $repository
     */
    public function __construct(public ProductRepository $productRepository) {}
    


    public function globalSearch(String $parameter = '')
    {
        if($parameter == '')
        {
            return [
                'success'=>true,
                'status'=>200 ,
                'data'=> [],
                'message'=>trans("products.api.products_retrived")
            ];
        }
        $products = $this->productRepository->all()
        ->where('name->ar', 'LIKE', "%{$parameter}%")
        ->orWhere('name->en', 'LIKE', "%{$parameter}%")
        ->available()
        ->paginate(10);
        return [
            'success'=>true,
            'status'=>200 ,
            'data'=> ProductResource::collection($products),
            'message'=>trans("products.api.products_retrived")
        ];  
    }

}
