@extends('admin.layouts.master')
@section('title')
    @lang('admin.sliders.update')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
<style>
   .imgContainer  {
        display: flex;
    flex-wrap: wrap;
    padding: 10px;
    background: #fff;
    gap: 20px;
     }
    .imgContent {
        padding: 6px;
    border: 1px solid #ccc;
    position: relative;
     }
     .imgContent:hover .deletedImage{
    transition: all .4s;

    opacity: 1;
     }
.deletedImage {
    all: unset;
    position: absolute;
    left: 10px;
    top: 10px;
    color: red;
    background: #fff;
    padding: 5px;
    border-radius: 50%;
    width: 10px;
    height: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .4s;
    opacity: 0;
}
</style>
@section('content')
    @include('sweetalert::alert')
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang('admin.edit')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.slider.update', $slider->id) }}" method="post" class="form-steps" autocomplete="on" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                

                                
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="image">@lang('admin.sliders.image')</label>
                                            <div class="image--root image image-input-multiple image--hopper"
                                                data-style-button-remove-item-position="left"
                                                data-style-button-process-item-position="right"
                                                data-style-load-indicator-position="right"
                                                data-style-progress-indicator-position="right"
                                                data-style-button-remove-item-align="false" style="height: 76px;">
                                                <input class="image--browser" type="file"
                                                    id="image"
                                                    aria-controls="image"
                                                    aria-labelledby="image" multiple=""
                                                    name="image">
                                                <div class="imag3"
                                                    style="transform: translate3d(0px, 0px, 0px); opacity: 1;">
                                                    <label for="image" id="image"
                                                        aria-hidden="true">
                                                        @lang('admin.sliders.image')
                                                    </label>
                                                </div>
                                                <div class="image--list-scroller"
                                                    style="transform: translate3d(0px, 60px, 0px);">
                                                    <ul class="image--list" role="list"></ul>
                                                </div>
                                                <div class="image--panel image--panel-root" data-scalable="true">
                                                    <div class="image--panel-top image--panel-root"></div>
                                                    <div class="image--panel-center image--panel-root"
                                                        style="transform: translate3d(0px, 8px, 0px) scale3d(1, 0.6, 1);">
                                                    </div>
                                                    <div class="image--panel-bottom image--panel-root"
                                                        style="transform: translate3d(0px, 68px, 0px);"></div>
                                                </div><span class="image--assistant" id="image--assistant-gywirtjd3"
                                                    role="status" aria-live="polite" aria-relevant="additions"></span>
                                                <div class="image--drip"></div>
                                                <fieldset class="image--data"></fieldset>
                                                @error("image")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                




                                
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="submit"
                                        class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                        <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                        @lang('admin.create')
                                    </button>
                                </div>
                                
                            </form>
                            <hr>
                                    <div class="imgContainer">
                                        @foreach ($images as $image)

                                        <div class="imgContent">
                                        <img width="120" src="{{$image->getUrl('thumb')}}">

                                          <form method="post" action="{{route('admin.slider.delete-image' ,$image->id  )}}">
                                            
                                            @csrf
                                            <input type="hidden" name="slider_id" value="{{$slider->id}}">
                                            <button class="deletedImage">
                                                <i class="fa fa-times"></i>
                                            </button>
                                         </form>
                                            

                                        </div>
                                        @endforeach

                                    </div>    
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2_parent_id').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2_child_id').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>

    <script>
    ClassicEditor
        .create( document.querySelector( '#body_ar' ) )
        .catch( error => {
            console.error( error );
        } );
    ClassicEditor
        .create( document.querySelector( '#body_en' ) )
        .catch( error => {
            console.error( error );
        } );
    </script>
    
@endsection
