@extends('admin.layouts.master')
@section('title')
    @lang($translateBase. '.page-title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang($translateBase. '.edit')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route($routeBase. '.update', $model->id) }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('put')
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="areas-arabic-info" role="tabpanel" aria-labelledby="areas-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="title_ar">@lang($translateBase. '.title_ar')</label>
                                                        <input type="text" name="title_ar" class="form-control"
                                                            value="{{ $model->getTranslation('title', 'ar') }}"
                                                            id="title_ar"
                                                            placeholder="@lang($translateBase. '.title_ar')">
                                                        @error('title_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="title_en">@lang($translateBase. '.title_en')</label>
                                                        <input type="text" name="title_en" class="form-control"
                                                            value="{{ $model->getTranslation('title', 'en') }}"
                                                            id="title_en"
                                                            placeholder="@lang($translateBase. '.title_en')">
                                                        @error('title_en')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="paragraph_ar">@lang($translateBase. '.paragraph_ar')</label>
                                                        <textarea type="text" name="paragraph_ar" class="ckeditor form-control"
                                                            id="paragraph_ar" rows="5"
                                                            placeholder="@lang($translateBase. '.paragraph_ar')">{{ $model->getTranslation('paragraph', 'ar') }}</textarea>
                                                        @error('paragraph_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="paragraph_en">@lang($translateBase. '.paragraph_en')</label>
                                                        <textarea type="text" name="paragraph_en" class="ckeditor form-control"
                                                            id="paragraph_en" rows="5"
                                                            placeholder="@lang($translateBase. '.paragraph_en')">{{ $model->getTranslation('paragraph', 'en') }}</textarea>
                                                        @error('paragraph_en')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Of Arabic Info tab pane -->
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="submit"
                                        class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                        <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                        @lang('admin.edit')
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
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
@endsection
@section('script_bottom')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
@endsection