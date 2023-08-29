<?php

namespace App\Services\Api;

use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use App\Models\Vendor;
use App\Repositories\Api\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class FavoriteProductService
{
    /**
     * Vendor Service Constructor.
     *
     * @param Vendorepository $repository
     */
   public function __construct(public ProductRepository $repository) {}


   public function getFavoriteProducts()
   {
        $customer = auth('api')->user();

        $products = $customer->favorite_products()->get();
        return [
            'success'=>true,
            'status'=>200 ,
            'data'=> ProductResource::collection($products),
            'message'=>__('products.api.products_retrived')
        ];

   }

   public function addFavoriteProduct($product_id)
   {
        $customer = auth('api')->user();
        if($customer->favorite_products->contains($product_id))
            return [
                'success'=>true,
                'status'=>200 ,
                'data'=> [],
                'message'=>__('products.api.favorite.product_already_exists')
            ];

        if(empty($this->repository->getModelUsingID($product_id)))
            return [
                'success'=>false,
                'status'=>404 ,
                'data'=> [],
                'message'=>__('products.api.product_not_found')
            ];
        $products = $customer->favorite_products()->attach([$product_id]);
        return [
            'success'=>true,
            'status'=>200 ,
            'data'=> [],
            'message'=>__('products.api.favorite.product_added')
        ];

   }

   public function deleteFavoriteProduct($product_id)
   {
        $customer = auth('api')->user();

        $products = $customer->favorite_products()->detach([$product_id]);
        return [
            'success'=>true,
            'status'=>200 ,
            'data'=> [],
            'message'=>__('products.api.favorite.product_deleted')
        ];

   }



}
