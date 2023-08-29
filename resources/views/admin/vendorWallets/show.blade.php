@extends('admin.layouts.master')
@section('title')
    @lang("admin.vendorWallets.show")
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
                    @lang("admin.vendorWallets.show"): {{ $vendorWallet?->vendor?->owner?->name }}
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
                            <b>@lang("admin.vendorWallets.id")</b> {{ $vendorWallet->id }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.vendorWallets.vendor_name")</b> {{ $vendorWallet?->vendor?->name }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.vendorWallets.user_vendor_name")</b> {{ $vendorWallet?->vendor?->owner?->name }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.vendorWallets.amount")</b> 
                            {{ $vendorWallet->balance_in_sar  . ' ' . __('translation.sar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.vendorWallets.last_update")</b> {{ $vendorWallet?->updated_at?->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        @lang('admin.vendorWallets.transaction.title')
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route("admin.vendorWallets.update", $vendorWallet->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="amount" class="form-label">
                                    @lang("admin.vendorWallets.transaction.amount")
                                </label>
                                <input type="number" step="0.01" name="amount" class="form-control" placeholder="@lang("admin.vendorWallets.transaction.amount")"/>
                                @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-3">
                                <label for="receipt" class="form-label">
                                    @lang("admin.vendorWallets.transaction.receipt")
                                </label>
                                <input type="file" name="receipt" id="receipt">
                                @error('receipt')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-3">
                                <div class="justify-content-end">
                                    <label for="" class="form-label"></label>
                                    <button type="submit" class="form-control btn btn-primary" id="add-btn">
                                        @lang("admin.vendorWallets.subtract")
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <h5>
                        @lang("admin.vendorWallets.current_wallet_balance"): <span>{{ $vendorWallet->balance_in_sar . ' ' . __('translation.sar')}}</span>
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="wallets">
                <div class="card-header">
                    <h5>
                        @lang('admin.vendorWallets.transaction.wallet_transactions_log')
                    </h5>
                </div>
                <br>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="walletsTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.vendorWallets.transaction.id')</th>
                                    <th>@lang('admin.vendorWallets.transaction.amount')</th>
                                    <th>@lang('admin.vendorWallets.transaction.operation_type')</th>
                                    <th>@lang('admin.vendorWallets.transaction.reference')</th>
                                    <th>@lang('admin.vendorWallets.transaction.reference_id')</th>
                                    <th>@lang('admin.vendorWallets.transaction.order_code')</th>
                                    <th>@lang('admin.vendorWallets.transaction.admin_by')</th>
                                    <th>@lang('admin.vendorWallets.transaction.receipt_url')</th>
                                    <th>@lang('admin.vendorWallets.created_at')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach($transactions as $transactionRecord)
                                    <tr>
                                        <td class="transaction_id">{{ $transactionRecord->id }}</td>
                                        <td class="amount">
                                            {{ $transactionRecord->amount_in_sar   . ' ' . __('translation.sar') }}
                                        </td>
                                        <td class="operation_type">
                                            {{ \App\Enums\VendorWallet::getTypeWithClass($transactionRecord->operation_type)["name"] }}
                                        </td>
                                        <td class="refrence">{{ !empty($transactionRecord->reference) ? $transactionRecord->reference : trans("admin.not_found") }}</td>   
                                        <td class="refrence_id">{{ !empty($transactionRecord->reference_id) ? $transactionRecord->reference_id : trans("admin.not_found") }}</td>   
                                        <td class="refrence_id">{{ !empty($transactionRecord->code) ? $transactionRecord->code : trans("admin.not_found") }}</td>   
                                        <td class="by_admin">{{ !empty($transactionRecord->admin->name) ? $transactionRecord->admin->name : trans("admin.not_found") }}</td>   
                                        <td class="receipt">
                                            @if (!empty($transactionRecord->attachment_url))
                                                <a href="{{ $transactionRecord->attachment_url }}" target="_blank">
                                                    @lang("admin.vendorWallets.transaction.receipt_url")
                                                </a>
                                            @else
                                                @lang("admin.not_found")
                                            @endif
                                        </td>   
                                        <td class="amount">{{ $transactionRecord->created_at->translatedFormat('d-m-Y h:i A') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#0ab39c"
                                               style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">@lang('admin.vendorWallets.transaction.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $transactions->appends(request()->query())->links("pagination::bootstrap-4") }}
                            </div>
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
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
