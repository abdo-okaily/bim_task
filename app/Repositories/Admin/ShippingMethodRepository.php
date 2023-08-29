<?php

namespace App\Repositories\Admin;

use App\Models\ShippingMethod;
use Illuminate\Support\Collection;
use App\Repositories\Api\BaseRepository;

class ShippingMethodRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return ShippingMethod::class;
    }

    /**
     * Get List Of shipping methods As collection For Select Menu
     * 
     * @return Collection
     */
    public function shippingMethodsMenu() : Collection
    {
        return $this->all()->get();
    }

    public function getPaginated($request)
    {
        $query=$this->model;

        if($request->has("search")) {
            if($request->has("trans") && $request->trans != "all") {
                $query = $query->where('name->' . $request->trans, 'LIKE', "%{$request->input('search')}%");
            }else{
                $query = $query->where('name->ar', 'LIKE', "%{$request->search}%")
                ->orwhere('name->en', 'LIKE', "%{$request->search}%");

            }
        }
        return $query->paginate();
    }

    public function updateShippingMethod($request,$id)
    {
        $data=$request->all();
        $data['name']=['en'=>$request->name_en,'ar'=>$request->name_ar];
        $shippingMethod=$this->getModelUsingID($id);
        return $shippingMethod->update($data);
    }
}
