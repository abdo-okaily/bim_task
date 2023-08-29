<?php

namespace App\Services\Api;

use App\Models\Vendor;
use App\Repositories\Api\VendorRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class VendorService
{
    /**
     * Vendor Service Constructor.
     *
     * @param Vendorepository $repository
     */
    public function __construct(public VendorRepository $repository) {}

    /**
     * Get Vendors.
     *
     * @return Collection
     */
    public function getAllVendors() : Model
    {
        return $this->repository->all();
    }

    /**
     * Get Vendors with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllVendorsWithPagination(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->repository->all()->available()
                                ->where("is_active", true)
                                ->where("approval", "approved")
                                ->paginate($perPage);
    }

    /**
     * Get Vendors with pagination.
     *
     * @param integer $perPage
     * @return Array
     */
    public function getAllVendorsInfinityLoad(int $perPage = 10) : Array
    {
        $page = (request()->page ?? 1) ;
        $offset = ($page - 1) * $perPage;

        $vendors = $this->repository->all()->available()
                                ->where("is_active", true)
                                ->where("approval", "approved")
                                ->whereHas('availableProducts');

       $count = $vendors->count();

       $vendors = $vendors->offset($offset)->take($perPage)->get();
       

        $next = ($page * $perPage) < $count;
        
        return [
            'vendors' => $vendors, 
            'next' => $next,
        ];
                               
    }

    /**
     * Get Vendor using ID.
     *
     * @param integer $id
     * @return Vendor
     */
    public function getVendorUsingID(int $id) : Vendor
    {
        return $this->repository->all()->available()->where('id',$id)->first();
    }

    public function updateVendor($request,$id)
    {
        $request=$request->all();
        if ($request['cr'] && json_decode($request['cr'])->data != null) {
            $request['cr']=json_decode($request['cr'])->data;
        }
        if ($request['broc'] && json_decode($request['broc'])->data != null) {
            $request['broc']=json_decode($request['broc'])->data;
        }
        if ($request['tax_certificate'] && json_decode($request['tax_certificate'])->data != null) {
            $request['tax_certificate']=json_decode($request['tax_certificate'])->data;
        }
        $vendor=$this->repository->getModelUsingID($id);
        $this->repository->update($request,$vendor);
    }
    /**
     * Get Vendor using ID.
     *
     * @param integer $id
     * @return Vendor
     */
    public function getVendorWithPaginatedProduct(int $id,int $perPage = 10) : vendor
    {
        $vendor = $this->getVendorUsingID($id);
        $products = $vendor->products()->available()->paginate($perPage);

        $vendor->products = $products;
        return $vendor;
    }

            /**
     * Get Products with pagination.
     *
     * @param integer $perPage
     * @return array
     */
    public function getAllProductsInfinityLoad(int $vendor_id,int $perPage = 10 ) : Array
    {
        $page = (request()->page ?? 1) ;
        $offset = ($page - 1) * $perPage;
        
        $vendor = $this->getVendorUsingID($vendor_id);
        $products = $vendor->products()->available();
        $count = $products->count();
        
        $products = $products->offset($offset)->take($perPage)->get();
        $vendor->products = $products;

        $next = ($page * $perPage) < $count;
        
        return [
            'vendor' => $vendor, 
            'next' => $next,
        ];
    }

    public function checkAvilablity($id)
    {
        $vendor = $this->repository->getVendorIfAvailable($id);
        if($vendor == null)
            return false;
        return true;
    }

}
