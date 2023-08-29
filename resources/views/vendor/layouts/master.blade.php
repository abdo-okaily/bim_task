<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')| Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">

    @include('vendor.layouts.head-css')
</head>

@section('body')
    @include('vendor.layouts.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('vendor.layouts.topbar')
        @include('vendor.layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('vendor.layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    {{--@include('vendor.layouts.customizer')--}}

    <!--end row-->
    <button style="display:none;" id="show-success" type="button" data-toast data-toast-text="{{session()->get('success')}}" data-toast-gravity="top" data-toast-position="center" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs">Top Center</button>

    <!-- JAVASCRIPT -->
    @include('vendor.layouts.vendor-scripts')
    @include('sweetalert::alert')

    @if(session()->has('success'))
    <script>
        var toastLiveExample4 = $("#show-success");
        toastLiveExample4.click();        
    </script>
    @endif
</body>

</html>
