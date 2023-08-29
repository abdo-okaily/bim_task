@extends('admin.layouts.master')
@section('title')
    @lang('admin.recipes.update')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
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
                            <form action="{{ route('admin.recipe.update', $recipe->id) }}" method="post" class="form-steps" autocomplete="on" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="step-arrow-nav mb-4">
                                    <ul class="nav nav-pills custom-nav nav-justified" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="categories-arabic-info-tab"
                                                data-bs-toggle="pill" data-bs-target="#categories-arabic-info"
                                                type="button" role="tab" aria-controls="categories-arabic-info"
                                                aria-selected="true"
                                                data-position="0">{{ trans('admin.categories.arabic_date') }}</button>
                                        </li>
                                        <li class="nav-item" role="presentation">

                                            <button class="nav-link" id="categories-english-info-tab" data-bs-toggle="pill"
                                                data-bs-target="#categories-english-info" type="button" role="tab"
                                                aria-controls="categories-english-info" aria-selected="false"
                                                data-position="1" tabindex="-1">
                                                {{ trans('admin.categories.english_date') }}
                                                @if ($errors->has('question_en') || $errors->has('question_en'))
                                                    <span
                                                        class="badge bg-danger">{{ trans('admin.errors') . ' ' . count([$errors->has('question_en'), $errors->has('question_en')]) }}</span>
                                                @endif
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="categories-arabic-info" role="tabpanel"
                                        aria-labelledby="categories-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="title_ar">@lang('admin.recipes.title_ar')</label>
                                                        <input type="text" name="title_ar" class="form-control"
                                                            id="title_ar"
                                                            value="{{ $recipe->getTranslation('title', 'ar') }}"
                                                            placeholder="{{ trans('admin.recipes.title_ar') }}">
                                                        @error('title_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="short_desc_ar">@lang('admin.recipes.short_desc_ar')</label>
                                                        
                                                        <textarea name="short_desc_ar" class="form-control"
                                                            placeholder="@lang('admin.recipes.short_desc_ar')">{{ $recipe->getTranslation('short_desc', 'ar') }}</textarea>
                                                        @error('short_desc_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="body_ar">@lang('admin.recipes.body_ar')</label>
                                                        
                                                        <textarea class="form-control" id="body_ar" name="body_ar">{{ $recipe->getTranslation('body', 'ar') }}</textarea>
                                                        @error('body_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>            
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Of Arabic Info tab pane -->

                                    <!-- Start Of English Info tab pane -->
                                    <div class="tab-pane fade" id="categories-english-info" role="tabpanel"
                                        aria-labelledby="categories-english-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="title_en">@lang('admin.recipes.title_en')</label>
                                                        <input type="text" name="title_en" class="form-control"
                                                            id="title_en"
                                                            value="{{ $recipe->getTranslation('title', 'en') }}"
                                                            placeholder="{{ trans('admin.recipes.title_en') }}">
                                                        @error('title_en')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="short_desc_en">@lang('admin.recipes.short_desc_en')</label>
                                                        
                                                        <textarea name="short_desc_en" class="form-control"
                                                            placeholder="@lang('admin.recipes.short_desc_en')">{{ $recipe->getTranslation('short_desc', 'en') }}</textarea>
                                                        @error('short_desc_en')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="body_en">@lang('admin.recipes.body_en')</label>
                                                        
                                                        <textarea class="form-control" id="body_en" name="body_en">{{ $recipe->getTranslation('body', 'en') }}</textarea>
                                                        @error('body_en')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>            
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <!-- End Of English Info tab pane -->
                                    
                                    
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="image">@lang('admin.recipes.image')</label>
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
                                                        @lang('admin.recipes.image')
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
                                    <div class="col-lg-3" style="padding-top: 30px">
                                        <div class="mb-3">
                                            <div class="form-check form-switch form-switch-lg" dir="rtl">
                                                <input type="checkbox" {{ $recipe->most_visited == true ? "checked" : "" }} name="most_visited" class="form-check-input" id="most_visited">
                                                <label class="form-check-label" true-value="true" for="most_visited">@lang('admin.recipes.most_visited')</label>
                                            </div>
                                            @error('most_visited')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
