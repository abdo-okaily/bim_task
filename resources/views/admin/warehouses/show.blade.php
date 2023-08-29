@extends('admin.layouts.master')
@section('title')
    @lang("admin.warehouses.show")
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
                    @lang("admin.warehouses.show"): {{ $warehouse->name }}
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
                            <b>@lang("admin.warehouses.id")</b> {{ $warehouse->id }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.name_ar")</b> {{ $warehouse->getTranslation('name', 'ar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.name_en")</b> {{ $warehouse->getTranslation('name', 'en') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.torod_warehouse_name")</b> {{ !empty($warehouse->torod_warehouse_name) ? $warehouse->torod_warehouse_name : trans("admin.warehouses.not_found") }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.package_covered_quantity")</b> {{ $warehouse->package_covered_quantity }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.package_price")</b> {{ $warehouse->packagePrice }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.additional_unit_price")</b> {{ $warehouse->additionalUnitPrice }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.administrator_name")</b> {{ $warehouse->administrator_name }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.administrator_phone")</b> {{ $warehouse->administrator_phone }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.administrator_email")</b> {{ $warehouse->administrator_email }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.map")</b>
                            <br><br>
                            <div id="map" style="height: 400px"></div>
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

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script type="text/javascript">
        function initMap() {
            var lat = {{ !empty($warehouse->latitude) ? $warehouse->latitude : 24.7251918 }}
            var lng = {{ !empty($warehouse->longitude) ? $warehouse->longitude : 46.8225288 }}
          const myLatLng = { lat, lng };
          const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: myLatLng,
          });
  
          new google.maps.Marker({
            position: myLatLng,
            map,
            title: "Saudi Dates Warehouses Map!",
          });
        }
  
        window.initMap = initMap;
    </script>
  
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ config("app.google-map-api-key") }}&callback=initMap" ></script>
@endsection
