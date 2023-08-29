@extends('admin.layouts.master')
@section('title')
    @lang('admin.shippingMethods.create')
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
                            @lang('admin.shippingMethods.create')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.shipping-methods.update',$shippingMethod->id) }}" method="post" class="form-steps" autocomplete="on" enctype="multipart/form-data" >
                                @csrf
                                @method('PUT')
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="shipping-methods-arabic-info" role="tabpanel" aria-labelledby="shipping-methods-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div>
                                                        <label for="formFile" class="form-label">@lang('admin.shippingMethods.logo')</label>
                                                        <input class="form-control" name="logo" type="file" id="formFile">
                                                        @error('logo')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <img src="{{$shippingMethod->logo}}" style="height: 130px;width: 130px;margin-top: 7px;border-radius: 5px;" alt="">
                                                </div>
                                            </div>
                                            <!-- Name Arabic & English -->
                                            <div class="row" style="margin-top: 10px;">
                                                <div class="col-lg-6 mb-10">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name_ar">@lang('admin.shippingMethods.name_ar')</label>
                                                        <input type="text" name="name_ar" class="form-control"
                                                            value="{{ old("name_ar",$shippingMethod->getTranslation('name', 'ar')) }}"
                                                            id="name_ar"
                                                            placeholder="{{ trans('admin.shippingMethods.name_ar') }}">
                                                        @error('name_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name_en">@lang('admin.shippingMethods.name_en')</label>
                                                        <input type="text" name="name_en" class="form-control"
                                                            value="{{ old("name_en",$shippingMethod->getTranslation('name', 'en')) }}"
                                                            id="name_en"
                                                            placeholder="{{ trans('admin.shippingMethods.name_en') }}">
                                                        @error('name_en')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top : 10px;">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="delivery_fees">@lang('admin.shippingMethods.delivery_fees')</label>
                                                        <input type="text" name="delivery_fees" class="form-control"
                                                            value="{{ old("delivery_fees",$shippingMethod->delivery_fees) }}"
                                                            id="delivery_fees"
                                                            placeholder="{{ trans('admin.shippingMethods.delivery_fees') }}" 
                                                            step=".01">
                                                        @error('delivery_fees')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="delivery_fees_covered_kilos">@lang('admin.shippingMethods.delivery_fees_covered_kilos')</label>
                                                        <input type="text" 
                                                            name="delivery_fees_covered_kilos" 
                                                            class="form-control"
                                                            value="{{ old("delivery_fees_covered_kilos",$shippingMethod->delivery_fees_covered_kilos) }}"
                                                            id="delivery_fees_covered_kilos"
                                                            placeholder="{{ trans('admin.shippingMethods.delivery_fees_covered_kilos') }}" 
                                                            >
                                                        @error('delivery_fees_covered_kilos')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="additional_kilo_price">@lang('admin.shippingMethods.additional_kilo_price')</label>
                                                        <input type="text" 
                                                            name="additional_kilo_price" 
                                                            class="form-control"
                                                            value="{{ old("additional_kilo_price",$shippingMethod->additional_kilo_price) }}"
                                                            id="additional_kilo_price"
                                                            placeholder="{{ trans('admin.shippingMethods.additional_kilo_price') }}" 
                                                            step=".01">
                                                        @error('additional_kilo_price')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="cod_collect_fees">@lang('admin.shippingMethods.cod_collect_fees')</label>
                                                        <input type="text" 
                                                            name="cod_collect_fees" 
                                                            class="form-control"
                                                            value="{{ old("cod_collect_fees",$shippingMethod->cod_collect_fees) }}"
                                                            id="cod_collect_fees"
                                                            placeholder="{{ trans('admin.shippingMethods.cod_collect_fees') }}" 
                                                            step=".01">
                                                        @error('cod_collect_fees')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="integration_key">@lang('admin.shippingMethods.integration_key')</label>
                                                        <select class="select2 form-control" name="integration_key" id="select2_is_active">
                                                            <option selected value="">
                                                                @lang("admin.shippingMethods.choose_key")
                                                            </option>
                                                            @foreach ($integrationKeys as $key => $integrationKey)
                                                                <option value="{{$key}}" @selected($shippingMethod->integration_key == $key)>
                                                                    {{ $integrationKey }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('integration_key')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="integration_key">@lang('admin.shipping_type')</label>
                                                        <select class="select2 form-control" name="type" id="select2_is_active">
                                                            <option selected value="">
                                                                @lang("admin.shippingMethods.choose_type")
                                                            </option>
                                                            @foreach ($shipping_types as $key => $type)
                                                                <option value="{{$key}}" @selected($shippingMethod->type == $key)>
                                                                    {{ $type }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('type')
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
                                        @lang('admin.update')
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
            $('.select2_is_active').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>
@endsection
