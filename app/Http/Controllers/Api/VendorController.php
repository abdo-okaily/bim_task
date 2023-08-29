<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Services\Api\VendorService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\{
    AllVendorWithoutCartResource,
    ProductResource,
    SingleVendorWithoutCartResource,
    VendorDeatailsResource
};
use App\Services\Api\ProductService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VendorController extends ApiController
{
    /**
     * Vendor Controller Constructor.
     *
     * @param VendorService $service
     */
    public function __construct(public VendorService $service, public ProductService $productService)
    {
        //$this->middleware('api.auth');
    }

    /**
     * List all vendors.
     *
     * @return ResourceCollection
     */
    public function index() : ResourceCollection
    {
        $vendorsData = $this->service->getAllVendorsInfinityLoad();

        return AllVendorWithoutCartResource::collection($vendorsData['vendors'])->additional([
            "success" => true,
            "status" => 200,
            'next' => $vendorsData['next'],
            "message"=> trans("vendors.api.vendors_retrived")
        ]);
    }

    /**
     * Get Vendor using id.
     *
     * @param id $vendor_id
     * @return Response
     */
    public function show(int $vendor_id)
    {
        $vendorData = $this->service->getAllProductsInfinityLoad($vendor_id);
      
        return   ProductResource::collection($vendorData['vendor']->products)->additional([
            "vendor" => new VendorDeatailsResource($vendorData['vendor']),
            'next'    => $vendorData['next'],
            "success" => true,
            "status" => 200,
            "message"=> trans("products.api.products_retrived")
        ]);

    }


    /**
     * List all vendors.
     *
     * @return ResourceCollection
     */
    public function sortedProducts(int $id)
    {
        $filter = $_GET['filter'] ?? '';
        $products = $this->productService->getSortedProducts($id, $filter);
        $products->withPath("vendors/products/" . $id);

        return ProductResource::collection($products)->additional([
            "success" => true,
            "status" => 200,
            "message"=> trans("vendors.api.vendors_retrived")
        ]);
    }
}
