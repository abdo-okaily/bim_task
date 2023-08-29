<?php

namespace App\Services\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Repositories\SliderRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Services\LogService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SliderService
{
    /**
     * Slider Service Constructor.
     *
     * @param SliderRepository $repository
     */
    public function __construct(public SliderRepository $repository
    ,public LogService $logger
    ) {
        
    }

    /**
     * Get Sliders.
     *
     * @return Collection
     */
    public function getAllSliders() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Sliders with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllSlidersWithPagination($request, int $perPage = 10, string $orderBy = "desc") : LengthAwarePaginator
    {
        $Sliders = $this->repository
        ->all()
        ->newQuery();
        
        if($request->has("search")) {
                if($request->has("trans") && $request->trans != "all") {
                        $Sliders->where('title->' . $request->trans, 'LIKE', "%{$request->search}%");
                    }else{
                        $Sliders->where('title->ar', 'LIKE', "%{$request->search}%")
                        ->orwhere('title->en', 'LIKE', "%{$request->search}%");

                    }
                    
                }
                
        
        return $Sliders->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Slider using ID.
     *
     * @param integer $id
     * @return Slider
     */
    public function getSliderUsingID(int $id) : Slider
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New Slider.
     *
     * @param Request $request
     * @return array
     */
    public function createSlider(Request $request) : array
    {
       

        $slider = $this->repository->store(
            $request->except('_method', '_token')
        );



        if(!empty($slider)) {
            return [
                "success" => true,
                "title" => trans("admin.sliders.messages.created_successfully_title"),
                "body" => trans("admin.sliders.messages.created_successfully_body"),
                "id" => $slider->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.sliders.messages.created_error_title"),
            "body" => trans("admin.sliders.messages.created_error_body"),
        ];
             
    }

    /**
     * Update Slider Using ID.
     *
     * @param integer $Slider_id
     * @param Request $request
     * @return array
     */
    public function updateSlider(int $Slider_id, Request $request) : array
    {
        // $request->merge([
        //     "title" => [
        //         "ar" => $request->title_ar,
        //         "en" => $request->title_en
        //     ],
        //     "body" => [
        //         "ar" => $request->body_ar,
        //         "en" => $request->body_en
        //     ],
        //     "short_desc" => [
        //         "ar" => $request->short_desc_ar,
        //         "en" => $request->short_desc_en
        //     ],
        //     'most_visited'=> $request->most_visited,
        //     'image'=>'image/nologo.php'
        // ]);
        $Slider = $this->getSliderUsingID($Slider_id);
        
        $oldSliderObject = clone $Slider;
        
        $this->repository->update($request->except('_method', '_token'), $Slider);
        $this->_createImage($Slider, $request);
        

        $this->logger->InLog([
            'user_id' => auth()->user()->id,
            'action' => "UpdateSlider",
            'model_type' => "\App\Models\Slider",
            'model_id' => $Slider_id,
            'object_before' => $oldSliderObject,
            'object_after' => $Slider
        ]);
        return [
            "success" => true,
            "title" => trans("admin.sliders.messages.updated_successfully_title"),
            "body" => trans("admin.sliders.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete Slider Using.
     *
     * @param int $Slider_id
     * @return array
     */
    public function deleteSlider(int $Slider_id) : array
    {
        $Slider = $this->getSliderUsingID($Slider_id);
        $this->_deleteOldCategoryImage($Slider);
        $isDeleted = $this->repository->delete($Slider);
        
        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.sliders.messages.deleted_successfully_title"),
                "body" => trans("admin.sliders.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.sliders.messages.deleted_error_title"),
            "body" => trans("admin.sliders.messages.deleted_error_message"),
        ];
    }



    public function deleteSliderImage(Slider $slider, int $id)
    {

        $media = $slider->media->where('id', $id)->first();

        if(!empty($media)) {
            $media->delete();
        }

        return [
            "success" => true,
            "title" => trans("admin.sliders.messages.deleted_successfully_title"),
            "body" => trans("admin.sliders.messages.deleted_successfully_message"),
        ];

        
    }

    private function _createImage(Slider $Slider, Request $request) : void
    {
        if($request->has("image")) {
            $fileName = "image_" . time();
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $Slider->addMediaFromRequest("image")
                   ->usingName($fileName)
                   ->setFileName($fileName . '.' .  $fileExtension)
                   ->toMediaCollection("sliders");
        }
    }

    private function _updateImage(Slider $Slider, Request $request) : void
    {
        if($request->has("image")) {
            // $this->_deleteOldCategoryImage($Slider);
            $fileName = "image_" . time();
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $Slider->addMediaFromRequest("image")
                   ->usingName($fileName)
                   ->setFileName($fileName . '.' .  $fileExtension)
                   ->toMediaCollection("sliders");
        }
    }

    
    private function _deleteOldCategoryImage(Slider $Slider) : void
    {
        $media = $Slider->media->first();

        if(!empty($media)) {
            $media->delete();
        }

        
    }
}
