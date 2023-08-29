@extends('admin.layouts.master')
@section('title') @lang('admin.vendors_show') @endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('admin.customer_details')</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label">@lang('admin.customer_name')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer->name }}">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">@lang('admin.customer_email')</label>
                            <input disabled="disabled" readonly type="email" class="form-control" value="{{ $customer->email }}">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">@lang('admin.customer_phone')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer->phone }}">
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress2" class="form-label">@lang('admin.customer_registration_date')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ date('d-m-Y h:i', strtotime($customer->created_at)) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress2" class="form-label">@lang('admin.customer_finances.payment_methods.wallet')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer?->ownWallet?->amount_with_sar  . '  ' . __('translation.sar')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('admin.customer_addresses')</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="row gy-4">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('admin.address_description')</th>
                                <th scope="col">@lang('admin.address_type')</th>
                                <th scope="col">@lang('admin.created_at')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customer->addresses As $address)
                                <tr>
                                    <th scope="row">{{ $address->id }}</th>
                                    <td>{{ $address->description }}</td>
                                    <td>{{ $address->type }}</td>
                                    <td>{{ date('d-m-Y h:i', strtotime($customer->created_at)) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('admin.transactions')</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="row gy-4">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">@lang('admin.transaction_id')</th>
                                <th scope="col">@lang('admin.total_sub')</th>
                                <th scope="col">@lang('admin.address_id')</th>
                                <th scope="col">@lang('admin.transaction_status')</th>
                                <th scope="col">@lang('admin.transaction_date')</th>
                                <th scope="col">@lang('admin.transaction_show')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customer->transactions As $transaction)
                                <tr>
                                    <th scope="row">{{ $transaction->id }}</th>
                                    <td>{{ $transaction->total .'  '. __('translation.sar') }}</td>
                                    <td>{{ $transaction->address_id }}</td>
                                    <td>{{ __('admin.' . $transaction->status) }}</td>
                                    <td>{{ date('d-m-Y h:i', strtotime($transaction->created_at)) }}</td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                <a href="{{ route('admin.transactions.show', ['transaction' => $transaction]) }}" class="text-primary d-inline-block">
                                                    <i class="ri-eye-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<form action="javascript:void(0);" class="row g-3">
        <div class="col-md-6">
            <label for="username" class="form-label">@lang('admin.customer_phone')</label>
            <span class="d-flex align-items-center">
                <img class="rounded-circle header-profile-user" src="{{ URL::asset($customer->logo) }}" alt="Header Avatar">
            </span>
        </div>
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">@lang('admin.vendor_address')</label>
            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer->street }}">
        </div>
        <div class="col-md-6">
            <label for="inputAddress2" class="form-label">@lang('admin.vendor_phone')</label>
            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer->phone }}">
        </div>
        <div class="col-md-6">
            <label for="inputAddress2" class="form-label">@lang('admin.vendor_tax_number')</label>
            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer->tax_num }}">
        </div>
        <div class="col-md-6">
            <label for="inputAddress2" class="form-label">@lang('admin.vendor_tax_certificate')</label>
            <input disabled="disabled" readonly type="text" class="form-control" value="{{ URL::asset($customer->tax_certificate) }}">
        </div>
        <div class="col-md-6">
            <label for="inputAddress2" class="form-label">@lang('admin.vendor_commercial_register')</label>
            <input disabled="disabled" readonly type="text" class="form-control" value="{{ URL::asset($customer->cr) }}">
        </div>
        <div class="col-md-6">
            <label for="inputAddress2" class="form-label">@lang('admin.vendor_commercial_register_date')</label>
            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer->crd }}">
        </div>
        <div class="col-md-6">
            <label for="inputAddress2" class="form-label">@lang('admin.vendor_bank')</label>
            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer->bank_name }}">
        </div>
        <div class="col-md-6">
            <label for="inputAddress2" class="form-label">@lang('admin.vendor_bank_number')</label>
            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer->bank_num }}">
        </div>
        <div class="col-md-6">
            <label for="inputAddress2" class="form-label">@lang('admin.vendor_broc')</label>
            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer->ipan }}">
        </div>
    </form>--}}
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
