@extends('admin.layouts.master')
@section('title')
    @lang('admin.carts_list')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('admin.cart_price')</th>
                                <th scope="col">@lang('admin.cart_products_count')</th>
                                <th scope="col">@lang('admin.cart_customer_name')</th>
                                <th scope="col">@lang('admin.created_at')</th>
                                <th scope="col">@lang('admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                                <tr>
                                    <td>{{ $cart->id }}</td>
                                    <td>{{ $cart->cart_total_in_sar .' '. __('translation.sar') }}</td>
                                    <td>{{ $cart->products->count() }}</td>
                                    <td>{{ $cart->user->name }}</td>
                                    <td>{{ date('d-m-Y h:i', strtotime($cart->created_at)) }}</td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            <a href="{{ route('admin.carts.show', ['cart' => $cart]) }}" class="fs-15">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.carts.delete', ['cart' => $cart]) }}" class="fs-15 link-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $carts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
