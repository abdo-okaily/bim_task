@extends('admin.layouts.master')
@section('title')
    @lang("admin.countries.show")
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
                    @lang("admin.countries.show"): {{ $country->name }}
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
                            <b>@lang("admin.countries.id")</b> {{ $country->id }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.countries.name_ar")</b> {{ $country->getTranslation('name', 'ar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.countries.name_en")</b> {{ $country->getTranslation('name', 'en') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.countries.code")</b> {{ $country->code }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.countries.vat_percentage")</b> {{ $country->vat_percentage }}%
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.countries.is_active")</b>
                            <span class="{{ \App\Enums\CountryStatus::getStatusWithClass($country->is_active)["class"] }}">
                                {{ \App\Enums\CountryStatus::getStatusWithClass($country->is_active)["name"] }}
                            </span>
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.countries.is_national")</b>
                            <span class="{{ \App\Enums\NationalCountry::getTypeWithClass($country->is_national)["class"] }}">
                                {{ \App\Enums\NationalCountry::getTypeWithClass($country->is_national)["name"] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="card-header  border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @lang("admin.countries.country_areas"):
                </h5>
            </div>
        </div>
    </div>
    <br>
    @if ($country->areas->count() > 0)
        <div class="row">
            <div class="col-xxl-12">
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="areasTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.areas.id')</th>
                                    <th>@lang('admin.areas.name_ar')</th>
                                    <th>@lang('admin.areas.name_en')</th>
                                    <th>@lang('admin.areas.is_active')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if ($country->areas->count() > 0)
                                        @foreach($country->areas as $area)
                                            <tr>
                                                <td class="id">
                                                    <a href="{{ route("admin.areas.show", $area->id) }}"class="fw-medium link-primary">
                                                        #{{$area->id}} 
                                                    </a>
                                                </td>
                                                <td class="name_ar">{{ $area->getTranslation('name', 'ar') }}</td>
                                                <td class="name_en">{{ $area->getTranslation('name', 'en') }}</td>
                                                <td class="is_active">
                                                    <span class="{{ \App\Enums\CityStatus::getStatusWithClass($area->is_active)["class"] }}">
                                                        {{ \App\Enums\CityStatus::getStatusWithClass($area->is_active)["name"] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.areas.show')">
                                                            <a target="_blank" href="{{ route("admin.areas.show", $area->id) }}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-eye-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan = "4">
                                                <center>
                                                    @lang('admin.areas.not_found')
                                                </center>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-xxl-5">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="card-body border-end">
                                <p>@lang("admin.countries.not_found")</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
