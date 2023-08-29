@extends('admin.layouts.master')
@section('title')
    @lang('admin.dashboard')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <iframe id="dashboard-statistics" src="https://dash.ncpd.io/public/dashboard/0b8751d3-c164-40c0-b208-342054a899d0"
        frameborder="0" width="100%" height="2300" allowtransparency></iframe>
@endsection
@section('script')
    <script>
        window.setInterval("reloadIFrame();", 50000);

        function reloadIFrame() {
            document.getElementById("dashboard-statistics").src =
                "https://dash.ncpd.io/public/dashboard/0b8751d3-c164-40c0-b208-342054a899d0";
        }
    </script>
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/swiper/swiper.min.js') }}"></script>
    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
