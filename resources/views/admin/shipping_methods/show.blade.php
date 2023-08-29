@extends('admin.layouts.master')
@section('title')
    @lang("admin.shippingMethods.show")
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="card-header  border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @lang("admin.shippingMethods.show"): {{ $shippingMethod->name }}
                </h5>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xxl-5">
            <div class="card">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="card-body border-end">
                            <b>@lang("admin.shippingMethods.logo")</b> <img src="{{$shippingMethod->logo}}" style="width: 130px;height: 110px;border-radius: 9px;" > 
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.shippingMethods.id")</b> {{ $shippingMethod->id }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.shippingMethods.name_ar")</b> {{ $shippingMethod->getTranslation('name', 'ar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.shippingMethods.name_en")</b> {{ $shippingMethod->getTranslation('name', 'en') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.shippingMethods.integration_key")</b>
                            <span class="{{ \App\Enums\ShippingMethodKeys::getKeys()[$shippingMethod->integration_key] }}">
                            {{ \App\Enums\ShippingMethodKeys::getKeys()[$shippingMethod->integration_key] }}
                            </span>
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.shippingMethods.delivery_fees")</b>
                            {{ $shippingMethod->delivery_fees }} @lang('translation.sar')
                        </div>
                        @if($shippingMethod->delivery_fees_covered_kilos)
                            <div class="card-body border-end">
                                <b>@lang("admin.shippingMethods.delivery_fees_covered_kilos")</b>
                                {{ $shippingMethod->delivery_fees_covered_kilos }} @lang('translation.kilo')
                            </div>
                        @endif
                        <div class="card-body border-end">
                            <b>@lang("admin.shippingMethods.cod_collect_fees")</b>
                            {{ $shippingMethod->cod_collect_fees }} @lang('translation.sar')
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.shippingMethods.additional_kilo_price")</b>
                            {{ $shippingMethod->additional_kilo_price }} @lang('translation.sar')
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.shippingMethods.type")</b>
                            <span class="{{ \App\Enums\ShippingMethodKeys::getKeys()[$shippingMethod->integration_key] }}">
                                {{ \App\Enums\ShippingMethodType::getTypesList()[$shippingMethod->type] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xxl-7">
            <div class="card">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="car-body p-3">
                            <form method="POST" action="{{ route('admin.shipping-methods.sync-zones', ['shippingMethod' => $shippingMethod]) }}">
                                @csrf
                                <div class="form-group">
                                    <label> @lang('admin.shippingMethods.related-domestic-zones') </label>
                                    <select class="form-select" id="select2" multiple name="domesticZones[]">
                                        <option disabled> @lang('translation.select-option') </option>
                                        @foreach($domesticZones ?? [] as $domesticZone)
                                            <option @selected($shippingMethod->domesticZones->where('id', $domesticZone->id)->first())
                                                value="{{ $domesticZone->id }}"> {{ $domesticZone->name }} </option>
                                        @endforeach
                                    </select>
                                    @error('domesticZones')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @error('domesticZones.*')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <button class="btn btn-primary"> @lang('admin.save') </button>
                                </div>
                            </form>
                        </div>
                    </div>
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
            $("#select2").select2()
        })
    </script>
@endsection
