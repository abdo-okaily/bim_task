@extends('admin.layouts.master')
@section('title')
    @lang('admin.transactions_list')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.transactions')</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="get" action="{{ URL::asset('/admin') }}/transactions/">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-4">
                                <div class="search-box">
                                    <input value="{{ request('customer') }}" name="customer" type="text" class="form-control search" placeholder="@lang('admin.transaction_customer_filter_placeholder')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-4">
                                <div class="search-box">
                                    <input value="{{ request('transaction_id') }}" name="transaction_id" type="text" class="form-control search" placeholder="@lang('admin.transaction_id_filter_placeholder')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <input value="{{ request('from') }}" name="from" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-maxDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.from')">
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <input value="{{ request('to') }}" name="to" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-maxDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.to')">
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select name="status" class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idStatus">
                                        <option @if(request('status') == '') SELECTED @endif value="">@lang('admin.transaction_status')</option>
                                        <option @if(request('status') == 'registered') SELECTED @endif value="registered">@lang('admin.registered')</option>
                                        <option @if(request('status') == 'shipping_done') SELECTED @endif value="shipping_done">@lang('admin.shipping_done')</option>
                                        <option @if(request('status') == 'in_delivery') SELECTED @endif value="in_delivery">@lang('admin.in_delivery')</option>
                                        <option @if(request('status') == 'completed') SELECTED @endif value="completed">@lang('admin.completed')</option>
                                        <option @if(request('status') == 'canceled') SELECTED @endif value="canceled">@lang('admin.canceled')</option>
                                        <option @if(request('status') == 'refund') SELECTED @endif value="refund">@lang('admin.refund')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('translation.order_id')</th>
                                    <th>@lang('translation.customer')</th>
                                    <th>@lang('translation.products')</th>
                                    <th>@lang('admin.payment_method')</th>
                                    <th>@lang('admin.total')</th>
                                    <th>@lang('admin.paid_amount')</th>
                                    <th>@lang('admin.vendors_count')</th>
                                    <th>@lang('admin.shipping')</th>
                                    <th>@lang('translation.delivery_status')</th>
                                    <th>@lang('translation.order_date')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->code }}</td>
                                        <td>{{ $transaction->customer->name }}</td>
                                        <td>{{ (int)$transaction->products_count }}</td>
                                        <td>{{ App\Enums\PaymentMethods::getStatus($transaction->payment_method) }}</td>
                                        <td>{{ amountInSar($transaction->total) .'  '. __('translation.sar') }}</td>
                                        <td>{{ $transaction->total_amount_rounded .'  '. __('translation.sar') }}</td>
                                        <td>{{ $transaction->orders->count() }}</td>
                                        <td>#shipping data</td>
                                        <td><span data-status="{{ $transaction->status }}" class="badge badge-soft-secondary text-uppercase">{{ __('admin.' . $transaction->status) }}</span></td>
                                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString() }}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                    <a href="{{ route('admin.transactions.show', ['transaction' => $transaction]) }}" class="text-primary d-inline-block">
                                                        <i class="ri-eye-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="manage">
                                                    <a href="{{ route('admin.transactions.manage', ['transaction' => $transaction]) }}" class="text-primary d-inline-block">
                                                        <i class="ri-edit-2-fill"></i>
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
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
