@extends('admin.layouts.master')
@section('title')
    @lang('admin.warehouses.edit')
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
                            @lang('admin.warehouses.edit') {{ $warehouse->name }}
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.warehouses.update', $warehouse->id) }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('put')
                                <input type="hidden" name="warehouse_id" value="{{ $warehouse->id }}">
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
                                                        <label class="form-label" for="name_ar">@lang('admin.warehouses.name_ar')</label>
                                                        <input type="text" name="name_ar" class="form-control"
                                                            value="{{ $warehouse->getTranslation('name', 'ar') }}"
                                                            id="name_ar"
                                                            placeholder="{{ trans('admin.warehouses.name_ar') }}">
                                                        @error('name_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name_en">@lang('admin.warehouses.name_en')</label>
                                                        <input type="text" name="name_en" class="form-control"
                                                            value="{{ $warehouse->getTranslation('name', 'en') }}"
                                                            id="name_en"
                                                            placeholder="{{ trans('admin.warehouses.name_en') }}">
                                                        @error('name_en')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="torod_warehouse_name">@lang('admin.warehouses.torod_warehouse_name')</label>
                                                        <input type="text" name="torod_warehouse_name" class="form-control"
                                                            value="{{ $warehouse->torod_warehouse_name }}"
                                                            id="torod_warehouse_name"
                                                            placeholder="{{ trans('admin.warehouses.torod_warehouse_name') }}">
                                                        @error('torod_warehouse_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">@lang('admin.warehouses.countries')</label>
                                                        <select name="countries[]" multiple class="form-control" id="countries-select">
                                                            @foreach($countries ?? [] as $country)
                                                                <option value="{{ $country->id }}" @selected($warehouse->countries->where('id', $country->id)->isNotEmpty())>
                                                                    {{ $country->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('countries')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @error('countries.*')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="package_price">@lang('admin.warehouses.package_price') @lang('translation.sar')</label>
                                                        <input type="text" name="package_price" class="form-control"
                                                            value="{{ $warehouse->package_price }}"
                                                            id="package_price"
                                                            placeholder="{{ trans('admin.warehouses.package_price') }}">
                                                        @error('package_price')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="package_covered_quantity">@lang('admin.warehouses.package_covered_quantity')</label>
                                                        <input type="text" name="package_covered_quantity" class="form-control"
                                                            value="{{ $warehouse->package_covered_quantity }}"
                                                            id="package_covered_quantity"
                                                            placeholder="{{ trans('admin.warehouses.package_covered_quantity') }}">
                                                        @error('package_covered_quantity')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="additional_unit_price">@lang('admin.warehouses.additional_unit_price') @lang('translation.sar')</label>
                                                        <input type="text" name="additional_unit_price" class="form-control"
                                                            value="{{ $warehouse->additional_unit_price }}"
                                                            id="additional_unit_price"
                                                            placeholder="{{ trans('admin.warehouses.additional_unit_price') }}">
                                                        @error('additional_unit_price')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="administrator_name">@lang('admin.warehouses.administrator_name')</label>
                                                        <input type="text" name="administrator_name" class="form-control"
                                                            value="{{ $warehouse->administrator_name }}"
                                                            id="administrator_name"
                                                            placeholder="{{ trans('admin.warehouses.administrator_name') }}">
                                                        @error('administrator_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="administrator_phone">@lang('admin.warehouses.administrator_phone')</label>
                                                        <input type="text" name="administrator_phone" class="form-control"
                                                            value="{{ $warehouse->administrator_phone }}"
                                                            id="administrator_phone"
                                                            placeholder="{{ trans('admin.warehouses.administrator_phone') }}">
                                                        @error('administrator_phone')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="administrator_email">@lang('admin.warehouses.administrator_email')</label>
                                                        <input type="text" name="administrator_email" class="form-control"
                                                            value="{{ $warehouse->administrator_email }}"
                                                            id="administrator_email"
                                                            placeholder="{{ trans('admin.warehouses.administrator_email') }}">
                                                        @error('administrator_email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="map">@lang('admin.warehouses.map')</label>
                                                        <input type="hidden" name="latitude" value="{{ $warehouse->latitude }}" id="lat" readonly="yes"><br>
                                                        <input type="hidden" name="longitude" value="{{$warehouse->longitude}}" id="lng" readonly="yes">
                                                        @if($errors->has('latitude') && $errors->has('longitude'))
                                                            <span class="text-danger">
                                                                @lang("admin.warehouses.validations.latitude_required")
                                                            </span>
                                                        @endif
                                                        <br>
                                                        <div id="map" style="height: 400px"></div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#countries-select').select2()
        })
    </script>
    <script type="text/javascript">
        //Set up some of our variables.
        var map; //Will contain map object.
        var marker = false; ////Has the user plotted their location marker? 
        var warehouseLat = {{!empty($warehouse->latitude) ? $warehouse->latitude : 24.7251918}}
        var warehouseLong = {{!empty($warehouse->longitude) ? $warehouse->longitude : 46.8225288 }}
        //Function called to initialize / create the map.
        //This is called when the page has loaded.

        function changeMarker() {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(warehouseLat, warehouseLong),
                map: map,
                draggable: true //make it draggable
            });
        }
        function initMap() {
            //The center location of our map.
            var centerOfMap = new google.maps.LatLng(warehouseLat, warehouseLong);

            //Map options.
            var options = {
                center: centerOfMap, //Set center.
                zoom: 12 //The zoom value.
            };

            //Create the map object.
            map = new google.maps.Map(document.getElementById('map'), options);

            //Listen for any clicks on the map.
            google.maps.event.addListener(map, 'click', function(event) {                
                //Get the location that the user clicked.
                var clickedLocation = event.latLng;
                console.log("1", clickedLocation, "2", centerOfMap)
                //If the marker hasn't been added.
                if(marker === false){
                    //Create the marker.
                    marker = new google.maps.Marker({
                        position: clickedLocation,
                        map: map,
                        draggable: true //make it draggable
                    });
                    //Listen for drag events!
                    google.maps.event.addListener(marker, 'dragend', function(event){
                        markerLocation();
                    });
                } else{
                    //Marker has already been added, so just change its location.
                    marker.setPosition(clickedLocation);
                }
                //Get the marker's location.
                markerLocation();
            });

            changeMarker()
        }

        //This function will get the marker's current location and then add the lat/long
        //values to our textfields so that we can save the location.
        function markerLocation(){
            //Get location.
            var currentLocation = marker.getPosition();
            //Add lat and lng values to a field that we can save.
            document.getElementById('lat').value = currentLocation.lat(); //latitude
            document.getElementById('lng').value = currentLocation.lng(); //longitude
        }

        //Load the map when the page has finished loading.
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>
  
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ config("app.google-map-api-key") }}&callback=initMap" ></script>
@endsection
