<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\SettingRepository;

class SettingService
{
    /**
     * VendorWarehouseReques Service Constructor.
     *
     * @param SettingRepository $repository
     */
    public function __construct(private SettingRepository $repository) {}




        public function getAll( string $orderBy = "DESC")
        {
            return $this->repository
                ->all()
                ->newQuery()
                ->where('editable',1)
                ->orderBy("type", $orderBy)
                ->orderBy('input_type', 'ASC')
                ->get();
        }
    /**
     * Get Requests with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        return $this->repository
            ->all()
            ->newQuery()
            ->when($request->has('search'), fn($q) => $q->where('desc', 'LIKE', "%{$request->get('search')}%"))
            ->orderBy("created_at", $orderBy)
            ->paginate($perPage);
    }

    public function getSettingUsingID(int $id) 
    {
        return $this->repository
            ->all()
            ->where('id',$id)
            ->first();
    }

    public function updateSetting(Request $request)
    {

        foreach( $request->except('_token') as $key =>$value)
        {
            
            $setting = Setting::where('key',$key)->where('editable',1)->first();
           
            if($setting != null && $setting->editable != 1) {
               continue;
            }

            if(
                is_file($value)
            ) {
                $image_name = uploadFile($value, 'images/settings/');
                $image_name = ('images/settings/' . $image_name) ;    
                $setting = $this->repository->update(['value' => $image_name],$setting);
            } else {
                $setting = $this->repository->update(['value' => $value],$setting);   
            }
        }
        

      
            return [
                "success" => true,
                "title" => trans("admin.settings.messages.updated_successfully_title"),
                "body" => trans("admin.settings.messages.updated_successfully_body"),
              
            ];
        

          
    }

}
