@extends('admin.layouts.master')

@section('title')
    @lang('admin.transaction_invoice.header_title') #{{ $transaction->code }}
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xxl-9">
        <div class="card" id="demo">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-header border-bottom-dashed p-4">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6><span class="text-muted fw-normal"><b style="font-size: 18px">@lang("admin.transaction_invoice.app_name")</b></span></h6>
                                <h6><span class="text-muted fw-normal">@lang("admin.transaction_invoice.invoice_no"):</span><span id="transaction_id">#{{ $transaction->id }}</span></h6>
                                <h6><span class="text-muted fw-normal">@lang("admin.transaction_invoice.tax_no"):</span><span id="tax_no">{{ isset($settings["tax_no"]) && !empty($settings["tax_no"]) ? $settings["tax_no"] : ": 235781568" }}</span></h6>
                                @if (isset($transactoion->orderShip))
                                    <h6><span class="text-muted fw-normal">@lang("admin.transaction_invoice.shipment_no"):</span> {{ isset($transactoion->orderShip) ? $transactoion->orderShip->order_id : ": 6545645" }}</h6>
                                @endif
                                <h6 class="mb-0"><span class="text-muted fw-normal">@lang("admin.transaction_invoice.date"): </span><span id="contact-no"> {{ \Carbon\Carbon::parse($transaction->date)->format("d-m-Y H:i A") }}</span></h6>
                            </div>
                            <div class="flex-shrink-0 mt-sm-0 mt-3">
                                <img src="{{ isset($settings["site_logo"]) && !empty($settings["site_logo"]) ? url($settings["site_logo"]) : url("images/logo.svg") }}" class="card-logo card-logo-dark" alt="logo dark" height="90">
                                <img src="{{ isset($settings["site_logo"]) && !empty($settings["site_logo"]) ? url($settings["site_logo"]) : url("images/logo.svg") }}" class="card-logo card-logo-light" alt="logo light" height="90">
                            </div>
                        </div>
                        <center>
                            <h4 style="padding-right:51px">@lang("admin.transaction_invoice.invoice_brif")</h4>
                        </center>
                    </div>
                    <!--end card-header-->
                </div>
                <div class="card-body p-4 border-top border-top-dashed">
                    <div class="row g-3">
                        <div class="col-5">
                            <h6 class="text-muted text-uppercase fw-semibold mb-3">@lang("admin.transaction_invoice.bill_info")</h6>
                            <p class="text-muted mb-1" id="billing-address-line-1">@lang("admin.transaction_invoice.client_sale"): {{ $transaction->customer->name }}</p>
                            <p class="text-muted mb-1"><span>@lang("admin.transaction_invoice.phone"): </span><span id="billing-phone-no">{{ $transaction->customer->phone }}</span></p>
                        </div>
                        <!--end col-->
                        <div class="col-5">
                            <h6 class="text-muted text-uppercase fw-semibold mb-3">@lang("admin.transaction_invoice.ship_info")</h6>
                            <p class="text-muted mb-1" id="shipping-name">@lang("admin.transaction_invoice.client_name"): {{ $transaction->addresses->first_name }} {{ $transaction->addresses->last_name }}</p>
                            <p class="text-muted mb-1" id="shipping-address-line-1">@lang("admin.transaction_invoice.address"): {{ $transaction->addresses->description }}</p>
                            <p class="text-muted mb-1"><span>@lang("admin.transaction_invoice.phone"): </span><span id="shipping-phone-no">@lang("admin.transaction_invoice.phone"): {{ $transaction->addresses->phone }}</span></p>
                        </div>
                        <!--end col-->
                        <div class="col-2">
                            <p class="text-muted mb-2 text-uppercase fw-semibold">@lang("admin.payment_method")</p>
                            <span class="badge badge-soft-success fs-11" id="payment-status">
                                {{ \App\Enums\PaymentMethods::getStatusWithClass($transaction->payment_method)["name"] }}
                            </span>
                        </div><!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            @if($transaction->orders->count() > 0)
                                @foreach ($transaction->orders as $order)
                                    <div class="row">
                                        <div class="col-md-6">
                                            @lang("admin.vendor_name"): {{ $order->vendor->name }}
                                        </div>
                                        <div class="col-md-4">
                                            @lang("translation.tax_num"): {{ $order->vendor->tax_num }}
                                        </div>
                                        <div class="col-md-2">
                                            @lang("admin.transaction_invoice.invoice_no"): #{{ $order->id }}
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th 
                                                style="width: 100px; white-space: normal;"
                                                scope="col">@lang("admin.transaction_invoice.products_table_header.product_details")</th>
                                                <th 
                                                style="width: 100px; white-space: normal;"
                                                scope="col">@lang("admin.transaction_invoice.products_table_header.rate")</th>
                                                <th 
                                                style="width: 100px; white-space: normal;"

                                                scope="col">@lang("admin.transaction_invoice.products_table_header.quantity")</th>
                                                <th 
                                                style="width: 100px; white-space: normal;"

                                                scope="col">@lang("admin.transaction_invoice.products_table_header.amount")</th>
                                                <th
                                                style="width: 100px; white-space: normal;"
                                                scope="col">@lang("admin.transaction_invoice.products_table_header.tax_value")</th>
                                                <th 
                                                style="width: 100px; white-space: normal;"
                                                scope="col">@lang("admin.transaction_invoice.products_table_header.total_with_tax")</th>
                                            </tr>
                                        </thead>
                                        <tbody id="products-list">
                                                @foreach ($order->orderProducts as $productItem)
                                                    <tr>
                                                        <td 
                                                        
                                                        style="max-width: 100px"
                                                        class="text-start">
                                                            <span class="fw-medium" style="white-space: normal;">{{ $productItem->product?->name }}</span>
                                                            <p class="text-muted mb-0" style="white-space: normal;">
                                                                @lang("admin.transaction_invoice.products_table_header.barcode"): {{$productItem->product?->sku}}
                                                            </p>
                                                        </td>
                                                        <td>{{ $productItem->unit_price_in_sar_rounded }} @lang("translation.sar")</td>
                                                        <td>{{ $productItem->quantity }}</td>
                                                        <td>{{ $productItem->total_without_vat_in_sar_rounded }} @lang("translation.sar")</td>
                                                        <td>{{ $productItem->vat_rate_in_sar_rounded }} @lang("translation.sar") ({{ $productItem->vat_percentage }}%)</td>
                                                        <td>{{ $productItem->total_in_sar_rounded }} @lang("translation.sar")</td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                    </table><!--end table-->
                                    <br>
                                @endforeach
                            @else
                                <center>
                                    @lang("admin.transaction_invoice.not_found")
                                </center>
                            @endif
                        </div>
                        <div class="border-top border-top-dashed mt-2">
                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                <tbody>
                                    <tr>
                                        <td>@lang("admin.transaction_invoice.sub_total")</td>
                                        <td class="text-end">{{ $transaction->sub_total_in_sar_rounded }} @lang("translation.sar")</td>
                                    </tr>
                                    <tr>
                                        <td>@lang("admin.transaction_invoice.estimated_tax") ({{ isset($settings["tax"]) && !empty($settings["tax"]) ? $settings["tax"] : "15.00"}}%)</td>
                                        <td class="text-end">{{ $transaction->total_vat_in_sar_rounded }} @lang("translation.sar")</td>
                                    </tr>
                                    @if($transaction->discount)
                                    <tr>
                                        <td>@lang("admin.transaction_invoice.discount") <small class="text-muted"></small></td>
                                        <td class="text-end">- {{ $transaction->discount_in_sar_rounded }} @lang("translation.sar")</td>
                                    </tr>
                                    @endif
                                    @if($transaction->wallet_deduction)
                                    <tr>
                                        <td>@lang("admin.transaction_invoice.sub_from_wallet") <small class="text-muted"></small></td>
                                        <td class="text-end"> {{ $transaction->wallet_deduction_in_sar_rounded }} @lang("translation.sar")</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>@lang("admin.transaction_invoice.sub_total_without_vat") <small class="text-muted"></small></td>
                                        <td class="text-end"> {{ $transaction->total_without_vat ? $transaction->total_without_vat : 0 }} @lang("translation.sar")</td>
                                    </tr> 
                                    <tr>
                                        <td>@lang("admin.transaction_invoice.vat_percentage") <small class="text-muted"></small></td>
                                        <td class="text-end"> {{ $transaction->vat_percentage ? $transaction->vat_percentage : 0 }} @lang("translation.sar")</td>
                                    </tr> 
                                    <tr>
                                        <td>@lang("admin.transaction_invoice.vat_rate") <small class="text-muted"></small></td>
                                        <td class="text-end"> {{ $transaction->vat_rate ? $transaction->vat_rate : 0 }} @lang("translation.sar")</td>
                                    </tr>                                    
                                    <tr>
                                        <td>@lang("admin.transaction_invoice.shipping_charge")</td>
                                        <td class="text-end">{{ $transaction->delivery_fees_in_sar_rounded }} @lang("translation.sar")</td>
                                    </tr>
                                    <tr class="border-top border-top-dashed fs-15">
                                        <th scope="row">@lang('admin.transaction_invoice.total_amount')</th>
                                        <th class="text-end">{{ $transaction->total_amount_rounded }} @lang("translation.sar")</th>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <a href="javascript:window.print()" class="btn btn-soft-primary"><i class="ri-printer-line align-bottom me-1"></i> @lang("admin.transaction_invoice.print")</a>
                            <a href="{{ route("admin.transactions.pdf-invoice", $transaction->id) }}" class="btn btn-soft-success"><i class="ri-printer-line align-bottom me-1"></i> @lang("admin.transaction_invoice.download")</a>
                        </div>
                    </div>
                    <!--end card-body-->
                </div><!--end col-->
            </div><!--end row-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
