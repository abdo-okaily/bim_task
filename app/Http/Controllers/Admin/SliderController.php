<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateSliderRequest;
use App\Services\Admin\SliderService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class SliderController extends Controller
{
    

    /**
     * @param SliderService $service
     */
    public function __construct(
        public SliderService $service,
    ) {}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $sliders = $this->service->getAllSlidersWithPagination($request,20);
        return view("admin.slider.index",compact('sliders'));
    }

    public function show(int $id)
    {
        $Slider = $this->service->getSliderUsingID($id);
        return view("admin.slider.show", compact('Slider'));
    }
    
    // public function create(){
    //     $breadcrumbParent = 'admin.slider.index';
    //     $breadcrumbParentUrl = route('admin.slider.index');

    //     return view('admin.slider.create', compact("breadcrumbParent", "breadcrumbParentUrl"));
    // }

    // public function store(Request $request){

    //     $result = $this->service->createSlider($request);

    //     if($result["success"] == true) {
    //         Alert::success($result["title"], $result["body"]);
    //         return redirect()->route("admin.slider.index");
    //     }

    //     Alert::error($result["title"], $result["body"]);
    //     return redirect()->back();
    // }


    public function edit(int $id)
    {
        $slider =  $this->service->getSliderUsingID($id);
        $images = $slider->getMedia('sliders');
        $breadcrumbParent = 'admin.slider.index';
        $breadcrumbParentUrl = route('admin.slider.index');

        return view("admin.slider.edit", compact('slider','images', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update the category..
     *
     * @param  UpdateCategoryRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(Request $request, int $id)
    {
        $result = $this->service->updateSlider($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->back();
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    public function destroy(int $id)
    {
        $result = $this->service->deleteSlider($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.slider.index');
    }

    public function deleteImage(  Request $request, int $id)
    {

        $slider = $this->service->getSliderUsingID($request->slider_id);
        $result = $this->service->deleteSliderImage($slider, $id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->back();

    }
}
