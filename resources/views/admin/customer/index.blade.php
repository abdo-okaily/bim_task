@extends('admin.layouts.master')
@section('title')
    @lang('admin.customers_list')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom-dashed border-bottom">
                    <form method="get" action="{{ URL::asset('/admin') }}/customers/">
                        <div class="row g-3">
                            <div class="col-xl-3">
                                <div class="search-box">
                                    <input value="{{ request('name') }}" type="text" name="name" class="form-control search" placeholder="@lang('admin.customer_name')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="search-box">
                                    <input value="{{ request('email') }}" type="text" name="email" class="form-control search" placeholder="@lang('admin.customer_email')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="search-box">
                                    <input value="{{ request('phone') }}" type="text" name="phone" class="form-control search" placeholder="@lang('admin.customer_phone')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xl-3">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                {{--<th scope="col">@lang('admin.customer_avatar')</th>--}}
                                <th scope="col">@lang('admin.customer_name')</th>
                                <th scope="col">@lang('admin.customer_email')</th>
                                <th scope="col">@lang('admin.customer_phone')</th>
                                <th scope="col">@lang('admin.customer_addresses_count')</th>
                                <th scope="col">@lang('admin.customer_transactions_count')</th>
                                <th scope="col">@lang('admin.customer_priority')</th>
                                <th scope="col">@lang('admin.customer_banned')</th>
                                <th scope="col">@lang('admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    {{--<td>
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset($customer->avatar) }}" class="avatar-xs rounded-circle">
                                            </div>
                                        </div>
                                    </td>--}}
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ (int)$customer->addresses->count() }}</td>
                                    <td>{{ (int)$customer->transactions->count() }}</td>
                                    <td>
                                        <select onchange="customerChangePriority('{{ $customer->id }}',this)" data-priority="{{ $customer->priority }}" class="form-select mb-3">
                                            @foreach($customer->customer_priorities As $priority)
                                                <option @if($customer->priority == $priority) selected @endif value="{{ $priority }}">@lang('admin.customer_' . $priority)</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td id="customerBanned_{{ $customer->id }}">
                                        @if($customer->is_banned == 1)
                                            @lang('admin.yes')
                                        @else
                                            @lang('admin.no')
                                        @endif
                                    </td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            <a href="javascript:void(0);" onclick="customerApprove('{{ $customer->id }}',this);">
                                                @if($customer->is_banned == 1)
                                                    <i id="customer_approve_icon" class="ri-check-fill"></i>
                                                @else
                                                    <i id="customer_approve_icon" class="link-danger ri-indeterminate-circle-fill"></i>
                                                @endif
                                            </a>
                                            <a href="{{ route('admin.customers.show', ['user' => $customer]) }}" class="fs-15">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.customers.edit', ['user' => $customer]) }}" class="fs-15">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
@section('script-bottom')
    <script>
        function customerChangePriority(customerId, item)
        {
            let priority = $(item).val();
            $.post("{{ URL::asset('/admin') }}/customers/priority/" + customerId, {
                id: customerId,
                priority: priority,
                "_token": "{{ csrf_token() }}"
            }, function (data)
            {
                if (data.status == 'success')
                {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>@lang('admin.customer_change_priority_message')</h4>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonClass: 'btn btn-primary w-xs mb-1',
                        cancelButtonText: '@lang('admin.back')',
                        buttonsStyling: false,
                        showCloseButton: true
                    });
                }
            }, "json");
        }
        function customerApprove(customerId, item)
        {
            let iconSpan = $(item).find('#customer_approve_icon');
            let customerBanned = $('#customerBanned_'+customerId);
            $.post("{{ URL::asset('/admin') }}/customers/block/" + customerId, {
                id: customerId,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                if (data.status == 'success')
                {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>' + data.message + '</h4>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 1000
                    });
                    if (data.data == 1)
                    {
                        iconSpan.removeClass('link-danger ri-indeterminate-circle-fill').addClass('ri-check-fill');
                        customerBanned.text('@lang('admin.yes')');
                    }
                    else
                    {
                        iconSpan.removeClass('ri-check-fill').addClass('link-danger ri-indeterminate-circle-fill');
                        customerBanned.text('@lang('admin.no')');
                    }
                }
            }, "json");
        }
    </script>
@endsection
