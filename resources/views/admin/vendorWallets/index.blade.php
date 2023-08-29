@extends('admin.layouts.master')
@section('title')
    @lang('admin.vendorWallets.title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="wallets">
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form action="{{ route("admin.vendorWallets.index") }}" method="get">
                        <div class="row g-3">
                            <div class="col-xxl-5 col-sm-6">
                                <div class="search-box">
                                    <input type="text" name="search" class="form-control search" value="{{ request()->get('search') }}"
                                           placeholder="@lang("admin.vendorWallets.search")">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                            @lang("admin.vendorWallets.filter")
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <br>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="walletsTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.vendorWallets.id')</th>
                                    <th>@lang('admin.vendorWallets.vendor_name_ar')</th>
                                    <th>@lang('admin.vendorWallets.vendor_name_en')</th>
                                    <th>@lang('admin.vendorWallets.user_vendor_name')</th>
                                    <th>@lang('admin.vendorWallets.amount')</th>
                                    <th>@lang('admin.vendorWallets.last_update')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach($vendorWallets as $wallet)
                                    <tr>
                                        <td class="id">
                                            <a href="{{ route("admin.wallets.show", $wallet->id) }}"class="fw-medium link-primary">
                                                #{{$wallet->id}} 
                                            </a>
                                        </td>
                                        <td class="admin_id">{{ $wallet->vendor?->getTranslation('name' ,'ar') }}</td>
                                        <td class="admin_id">{{ $wallet->vendor?->getTranslation('name' ,'en') }}</td>
                                        <td class="customer_id">{{ $wallet->vendor?->owner?->name }}</td>
                                        <td class="amount">{{ $wallet->balance_in_sar  . ' ' . __('translation.sar') }}</td>
                                        <td class="date">{{ $wallet->updated_at?->diffForHumans() }}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.vendorWallets.manage')">
                                                    <a href="{{ route("admin.vendorWallets.show", $wallet->id) }}"
                                                       class="text-primary d-inline-block">
                                                        <i class="ri-eye-fill fs-16"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
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
                                    <h5 class="mt-2">@lang('admin.vendorWallets.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $vendorWallets->appends(request()->query())->links("pagination::bootstrap-4") }}
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
@endsection
