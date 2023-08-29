@extends('admin.layouts.master')
@section('title')
    @lang("admin.areas.show")
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
                    @lang("admin.areas.show"): {{ $area->name }}
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
                            <b>@lang("admin.areas.id")</b> {{ $area->id }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.areas.name_ar")</b> {{ $area->getTranslation('name', 'ar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.areas.name_en")</b> {{ $area->getTranslation('name', 'en') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.areas.country_id")</b>
                            <a target="_blank" href="{{ route("admin.countries.show", $area->country->id) }}">
                                 {{ $area->country->getTranslation("name", "ar") }} - {{ $area->country->getTranslation("name", "en") }}
                            </a>
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.cities.is_active")</b>
                            <span class="{{ \App\Enums\CityStatus::getStatusWithClass($area->is_active)["class"] }}">
                                {{ \App\Enums\CityStatus::getStatusWithClass($area->is_active)["name"] }}
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
                    @lang("admin.cities.areas_cities"):
                </h5>
            </div>
        </div>
    </div>
    <br>
    @if ($area->cities->count() > 0)
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
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if ($area->cities->count() > 0)
                                        @foreach($area->cities as $city)
                                            <tr>
                                                <td class="id">
                                                    <a href="{{ route("admin.cities.show", $city->id) }}"class="fw-medium link-primary">
                                                        #{{$city->id}} 
                                                    </a>
                                                </td>
                                                <td class="name_ar">{{ $city->getTranslation('name', 'ar') }}</td>
                                                <td class="name_en">{{ $city->getTranslation('name', 'en') }}</td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.cities.show')">
                                                            <a target="_blank" href="{{ route("admin.cities.show", $city->id) }}"
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
                                                    @lang('admin.cities.not_found')
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
