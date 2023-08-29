<?php

namespace App\Services\Api;

use App\Http\Resources\Api\ProductReviewResource;
use App\Models\Product;
use App\Repositories\Api\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ProductService
{
    /**
     * Product Service Constructor.
     *
     * @param ProductRepository $repository
     */
    public function __construct(public ProductRepository $repository) {}

    /**
     * Get Products.
     *
     * @return Collection
     */
    public function getAllProducts() : Collection
    {
        return $this->repository->all()->withAvg('reviews','rate')->available()->with(['quantity_type'])
        ->withCount('reviews')->get();
    }

    /**
     * Get Products with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllProductsWithPagination(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->repository->all()->available()->with(['quantity_type'])
        ->paginate($perPage);
    }

        /**
     * Get Products with pagination.
     *
     * @param integer $perPage
     * @return array
     */
    public function getAllProductsInfinityLoad(int $perPage = 10 ) : Array
    {
        $page = (request()->page ?? 1) ;
        $offset = ($page - 1) * $perPage;
        
        $prouducts = $this->repository->all()->available()->with(['quantity_type']);
        $count = $prouducts->count();

        $prouducts = $prouducts->offset($offset)->take($perPage)->get();

        $next = ($page * $perPage) < $count;
        
        return [
            'products' => $prouducts,
            'next' => $next,
        ];
    }

    /**
     * Get Product using ID.
     *
     * @param integer $id
     * @return Product
     */
    public function getProductUsingID(int $id) : Product|null
    {
        return $this->repository->all()->available()
        ->where('id',$id)
        ->first();
        
    }

    /**
     * Get Products with pagination By category id.
     *
     * @param integer $category_id
     * @return LengthAwarePaginator
     */
    public function getProductsUsingCategotyID(int $category_id, $perPage=20) 
    {
        return $this->repository->all()->available()->with(['quantity_type'])
        ->where('category_id',$category_id)->paginate($perPage);
    }

    public function addProductReview(Request $request)
    {
        $product = $this->getProductUsingID($request->product_id);
        if($product == null)
            return ['success'=>false, 'status'=>404 ,
                   'data'=>[],'message'=>__('products.api.product_not_found')];
        $review = $this->repository->createReview($product,[
                'user_id'=>auth('api')->user()->id,
                'rate'=>$request->rate,
                'comment'=>$request->comment,
        ]);

         return [
            'success'=>true,
            'status'=>200 ,
            'data'=>new ProductReviewResource($review),
            'message'=>__('products.api.product_review_created')
        ];
    }



    public function getSortedProducts($vendor_id, $filter,$perPage=10)
    {
        $products = $this->repository->all()->available()->with(['quantity_type'])
        ->where('vendor_id',$vendor_id)
        ->withSum('orderProducts','quantity');

        if($filter == 'latest' || $filter == ''){
            $products = $products->orderBy('created_at','DESC');
        }
        if($filter == 'best_rate'){
            $products = $products->orderBy('reviews_avg_rate','DESC');
        }
        if($filter == 'best_selling'){
            $products = $products->orderBy('order_products_sum_quantity','DESC');
        }

        return $products->paginate($perPage);

    }

    public function checkAvilablity($id)
    {
        $vendor = $this->repository->getProductIfAvailable($id);
        if($vendor == null)
            return false;
        return true;

    }

}
