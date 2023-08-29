@extends('admin.layouts.master')
@section('title')
    @lang('admin.transaction_show')
@endsection
@section('content')
    @if(session()->has('error'))
        <div class="alert alert-danger"> {{ session('error') }} </div>
    @endif
    <form id="transaction-edit" class="needs-validation row" novalidate method="POST"
        action="{{ route('admin.transactions.update', ['transaction' => $transaction->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('admin.transaction_main_details')</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-md-4">
                                <div>
                                    <label for="placeholderInput" class="form-label">@lang('admin.transaction_status')</label>
                                    <select @if($transaction->status == "completed")disabled @endif name="status" class="form-select rounded-pill mb-3">
                                        @foreach($statuses as $status => $statusText)
                                            <option @selected($transaction->status == $status) value="{{ $status }}">
                                                {{ $statusText }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div>
                                    <label for="placeholderInput" class="form-label">@lang('admin.transaction_note')</label>
                                    <textarea @if($transaction->status == "completed")disabled @endif name="note" class="form-control" rows="3">{{ $transaction->note }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @foreach($transaction->orders As $order)
                    <div class="card" id="order-{{ $order->id }}">
                        <div class="card-header">
                            <h4 class="float-start card-title mb-0 flex-grow-1">{{ __('admin.transaction_vendor_product', ['vendor' => $order->vendor->name]) }}</h4>
                            <div class="float-end">
                                <a href="javascript:void(0);" onclick="order_delete('{{ $order->id }}');" class="fs-15 link-danger">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-nowrap">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('admin.products.id')</th>
                                    <th scope="col">@lang('admin.products.single_title')</th>
                                    <th scope="col">@lang('admin.products.unitPrice')</th>
                                    <th scope="col">@lang('admin.quantity')</th>
                                    <th scope="col">@lang('admin.products.total')</th>
                                    <th scope="col">@lang('admin.last_update')</th>
                                    <th scope="col">@lang('admin.products.vendor')</th>
                                    <th scope="col">@lang('admin.actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->products As $product)
                                        <tr id="product-{{ $product->pivot->id  }}">
                                            <th scope="row">{{ $product->id }}</th>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ amountInSar($product->pivot->unit_price) .'  '. __('translation.sar') }}</td>
                                            <td>
                                                <div class="input-step">
                                                    <input disabled @if($transaction->status == "completed")disabled @endif name="quantity[{{ $product->pivot->id }}]" type="number" class="product-quantity" value="{{ $product->pivot->quantity }}" min="1" />
                                                </div>
                                            </td>
                                            <td>{{ amountInSar($product->pivot->total) }}</td>
                                            <td>{{ $product->pivot->updated_at }}</td>
                                            <td>{{ $product->vendor->name }}</td>
                                            <td>
                                                <div class="hstack gap-3 flex-wrap">
                                                    <a href="javascript:void(0);" onclick="product_delete('{{ $product->pivot->id }}');" class="fs-15 link-danger">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-md-12 mb-3">
                <div class="text-end">
                    <button @if($transaction->status == "completed")disabled @endif type="submit" class="btn btn-primary">@lang('admin.save')</button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
@section('script-bottom')
    <script>
        function order_delete(orderId)
        {
            alert("Edit transaction disabled")
            return
            $('<input>').attr({
                type: 'hidden',
                name: 'deletedOrders[]',
                value: orderId
            }).prependTo('#transaction-edit');

            $('#order-'+orderId).fadeOut("slow");
        }

        function product_delete(productOrderId)
        {
            alert("Edit transaction disabled")
            return
            $('<input>').attr({
                type: 'hidden',
                name: 'deletedProducts[]',
                value: productOrderId
            }).prependTo('#transaction-edit');

            $('#product-'+productOrderId).fadeOut("slow");
        }
    </script>
@endsection
