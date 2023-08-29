@extends('vendor.layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
{{-- <div class="row">
    <div class="col">
        <div class="h-100">
            <div class="row">
                <div class="row">    
                    <div class="col-xl-4 col-md-8">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            @lang("admin.statistics.admin.total_orders")
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value" data-target="12055"></span>
                                            @lang("admin.statistics.order")
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                            <i class="bx bx-shopping-bag text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-4 col-md-8">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            @lang("admin.statistics.admin.total_sales")
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value" data-target="22235.66">0</span>
                                            @lang("translation.sar")
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                            <i class="bx bx-wallet text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-4 col-md-8">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            @lang("admin.statistics.admin.total_revenues")
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value" data-target="32555.99">0</span>
                                            @lang("translation.sar")
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                            <i class="bx bx-wallet text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div>
            </div> <!-- end row-->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">
                                @lang("admin.statistics.admin.best_selling_products")
                            </h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table
                                    class="table table-hover table-centered align-middle table-nowrap mb-0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-sm bg-light rounded p-1 me-2">
                                                        <img src="{{ URL::asset('assets/images/products/img-1.png') }}"
                                                            alt="" class="img-fluid d-block" />
                                                    </div>
                                                    <div>
                                                        <h5 class="fs-14 my-1">
                                                            <a href="{{URL::asset('/admin/products')}}" class="text-reset">
                                                                تمور مدائن صالح
                                                            </a>
                                                        </h5>
                                                        <span class="text-muted">24 يناير 2023</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1 fw-normal">29.00 @lang('translation.sar')</h5>
                                                <span class="text-muted">@lang('translation.price')</span>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1 fw-normal">62</h5>
                                                <span class="text-muted">@lang('translation.no_orders')</span>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1 fw-normal">510</h5>
                                                <span class="text-muted">@lang('translation.available_stock')</span>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1 fw-normal">1,798 @lang('translation.sar')</h5>
                                                <span class="text-muted">@lang('translation.total_revenue')</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-sm bg-light rounded p-1 me-2">
                                                        <img src="{{ URL::asset('assets/images/products/img-3.png') }}"
                                                            alt="" class="img-fluid d-block" />
                                                    </div>
                                                    <div>
                                                        <h5 class="fs-14 my-1">
                                                            <a href="{{URL::asset('/admin/products')}}" class="text-reset">
                                                                تمر جده المفتخر
                                                            </a>
                                                        </h5>
                                                        <span class="text-muted">21 فبراير 2023</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1 fw-normal">33.00 @lang('translation.sar')</h5>
                                                <span class="text-muted">@lang('translation.price')</span>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1 fw-normal">40</h5>
                                                <span class="text-muted">@lang('translation.no_orders')</span>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1 fw-normal">422</h5>
                                                <span class="text-muted">@lang('translation.available_stock')</span>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1 fw-normal">2,798 @lang('translation.sar')</h5>
                                                <span class="text-muted">@lang('translation.total_revenue')</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-sm bg-light rounded p-1 me-2">
                                                        <img src="{{ URL::asset('assets/images/products/img-2.png') }}"
                                                            alt="" class="img-fluid d-block" />
                                                    </div>
                                                    <div>
                                                        <h5 class="fs-14 my-1">
                                                            <a href="{{URL::asset('/admin/products')}}" class="text-reset">
                                                                تمر جده
                                                            </a>
                                                        </h5>
                                                        <span class="text-muted">22 مارس 2023</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1 fw-normal">66.00 @lang('translation.sar')</h5>
                                                <span class="text-muted">@lang('translation.price')</span>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1 fw-normal">48</h5>
                                                <span class="text-muted">@lang('translation.no_orders')</span>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1 fw-normal">311</h5>
                                                <span class="text-muted">@lang('translation.available_stock')</span>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1 fw-normal">3,798 @lang('translation.sar')</h5>
                                                <span class="text-muted">@lang('translation.total_revenue')</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end row-->

            <div class="row">
                <div class="col-xl-4">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">
                                @lang("admin.statistics.admin.total_requests_according_to_status")
                            </h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div id="store-visits-source"
                                data-colors='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]'
                                class="apex-charts" dir="rtl"></div>
                        </div>
                    </div> <!-- .card-->
                </div> <!-- .col-->
                <div class="col-xl-8">
                    <!-- card -->
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">
                                @lang("admin.statistics.admin.total_requests_according_to_country")
                            </h4>
                        </div><!-- end card header -->

                        <!-- card body -->
                        <div class="card-body">

                            <div id="sales-by-locations"
                                data-colors='["--vz-light", "--vz-secondary", "--vz-primary"]'
                                style="height: 269px" dir="ltr"></div>

                            <div class="px-2 py-2 mt-1">
                                <p class="mb-1">المملكة العربية السعودية <span class="float-end">75%</span></p>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar progress-bar-striped bg-primary"
                                        role="progressbar" style="width: 75%" aria-valuenow="75"
                                        aria-valuemin="0" aria-valuemax="75">
                                    </div>
                                </div>

                                <p class="mt-3 mb-1">المملكة المغربية <span class="float-end">47%</span>
                                </p>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar progress-bar-striped bg-primary"
                                        role="progressbar" style="width: 47%" aria-valuenow="47"
                                        aria-valuemin="0" aria-valuemax="47">
                                    </div>
                                </div>

                                <p class="mt-3 mb-1">روسيا <span class="float-end">82%</span></p>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar progress-bar-striped bg-primary"
                                        role="progressbar" style="width: 82%" aria-valuenow="82"
                                        aria-valuemin="0" aria-valuemax="82">
                                    </div>
                                </div>

                                <p class="mt-3 mb-1">الهند <span class="float-end">22%</span></p>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar progress-bar-striped bg-primary"
                                        role="progressbar" style="width: 22%" aria-valuenow="22"
                                        aria-valuemin="0" aria-valuemax="22">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div> --}}
        </div> <!-- end .h-100-->

    </div> <!-- end col -->
</div>
@endsection
@section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/swiper/swiper.min.js')}}"></script>
<!-- dashboard init -->
<script src="{{ URL::asset('/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
