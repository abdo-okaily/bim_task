@extends('admin.layouts.master')
@section('title')
    @lang('qnas.admin.create')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang('admin.qnas.create')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.qna.store') }}" method="post" class="form-steps"
                                autocomplete="on" enctype="multipart/form-data">
                                @csrf
                                @method('post')
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
                                                @if ($errors->has('question_en') || $errors->has('answer_en'))
                                                    <span
                                                        class="badge bg-danger">{{ trans('admin.errors') . ' ' . count([$errors->has('question_en'), $errors->has('answer_en')]) }}</span>
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
                                                        <label class="form-label" for="name_ar">@lang('qnas.admin.question_ar')</label>
                                                        <input type="text" name="question_ar" class="form-control"
                                                            value="{{ old("question_ar") }}"
                                                            id="name_ar"
                                                            placeholder="{{ trans('qnas.admin.question_ar') }}">
                                                        @error('question_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="slug_ar">@lang('qnas.admin.answer_ar')</label>
                                                        
                                                        <textarea name="answer_ar" class="ckeditor form-control"
                                                            placeholder="@lang('qnas.admin.answer_ar')">{{ old("answer_ar") }}</textarea>
                                                        @error('answer_ar')
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
                                                        <label class="form-label" for="name_ar">@lang('qnas.admin.question_en')</label>
                                                        <input type="text" name="question_en" class="form-control"
                                                            value="{{ old("question_en") }}"
                                                            id="name_ar"
                                                            placeholder="{{ trans('qnas.admin.question_en') }}">
                                                        @error('question_en')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="slug_ar">@lang('qnas.admin.answer_en')</label>
                                                        
                                                        <textarea name="answer_en" class="ckeditor form-control"
                                                            placeholder="@lang('qnas.admin.answer_ar')">{{ old("answer_en") }}</textarea>
                                                        @error('answer_en')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Of English Info tab pane -->
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
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2_parent_id').select2({
                placeholder: "Select",
                allowClear: true
            });
            $('.ckeditor').ckeditor();
        });
    </script>
@endsection