<?php

namespace App\Services\Api;

use App\Enums\CategoryLevels;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\CategoryResource;
use App\Models\Category;
use App\Repositories\Api\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * Category Service Constructor.
     *
     * @param CategoryRepository $repository
     */
    public function __construct(public CategoryRepository $repository) {}

    /**
     * Get Category using ID.
     *
     * @param integer $id
     * @return Category
     */
    public function getCategoryUsingID(int $id) : Category|null
    {
        return $this->repository->getModelUsingID($id);
    }

    /**
     * Get Category Family Tree Parent Categories.
     *
     * @return Collection
     */
    public function getCategoryTreeAll(Category $category) : Category
    {
        if($category->level == CategoryLevels::PARENT)
        {
            $categories = $this->getParentsSubChildCategories($category->id);
        }
        elseif($category->level == CategoryLevels::CHILD)
        {
            $categories = $this->getParentsSubChildCategories($category->parent_id);
        }
        elseif($category->level == CategoryLevels::SUBCHILD)
        {
            $categories = $this->getParentsSubChildCategories($category->parent->parent_id);
        }
        else
        {
            $categories = [];
        }
        return $categories;
    }

    /**
     * Get Main Parent Categories.
     *
     * @return Collection
     */
    public function getParentsSubChildCategories(int $id) : Category
    {
        return Category::where('id', $id)
            ->active()
            ->whereNull('parent_id')
            ->with([
                'child' => function($childQuery)
                {
                    $childQuery->whereHas(
                        'subCategoryProduct', fn($q) => $q->available()
                    )
                    ->with([
                        'child' => function($leafChildQuery)
                        {
                            $leafChildQuery->whereHas(
                                'finalCategoryProduct', fn($q) => $q->available()
                            );
                        }
                    ]);
                }
            ])
            ->first();
    }

    /**
     * Get Selected Category with Products.
     * @param Category $category
     * @return array
     */
    public function getCategoryProducts(Category $category,int $perPage = 10) : array
    {
        $page = (request()->page ?? 1) ;
        $offset = ($page - 1) * $perPage;


        if ($category->level == CategoryLevels::PARENT)
        {
            $products = $category->categoryProduct();
        }
        elseif($category->level == CategoryLevels::CHILD)
        {
            $products = $category->subCategoryProduct();
        }
        elseif($category->level == CategoryLevels::SUBCHILD)
        {
            $products = $category->finalCategoryProduct();
        } 
        else
        {
            return [];
        }

        $count = $products->count();
        $products = $products->available()->offset($offset)->take($perPage)->get();
        $next = ($page * $perPage) < $count;

        return  [
            'info' => new CategoryResource($category),
            'products' => ProductResource::collection($products),
            'next' => $next
            
        ];
    }

    public function getHomePageCategory() : Collection
    {
        $categories =  $this->repository->all()->where('parent_id',null)->Active()
               ->whereHas('categoryProduct',function($q){
                $q->available();
               })
            // ->with(['categoryProduct'=>function($q){
            //     $q->withAvg('reviews','rate')->withSum('orderProducts','quantity')->withCount('reviews')->available()
            //         ->orderBy('created_at','DESC')->limit(20);
            // }])
            ->orderBy('order','asc')->get();

        // $filtered = $categories->filter(function ($value, $key) {
        //     return $value->products->count()> 0;
        // });
       return $categories;

    }
}
