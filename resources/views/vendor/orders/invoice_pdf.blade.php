<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang("translation.invoice")</title>
    <style>
      body {
        font-family: "bukrafont", sans-serif;
      }
    </style>
</head>
<body>
    <div class="content">
        <div class="header">
            <div class="flex-grow-1">
                <h6><span class="text-muted fw-normal"><b style="font-size: 18px">@lang("admin.transaction_invoice.app_name")</b></span></h6>
                <h6><span class="text-muted fw-normal">@lang("admin.transaction_invoice.invoice_no"):</span><span id="order_id">#{{ $order->id }}</span></h6>
                <h6><span class="text-muted fw-normal">@lang("admin.transaction_invoice.tax_no"):</span><span id="tax_no">{{ isset($settings["tax_no"]) && !empty($settings["tax_no"]) ? $settings["tax_no"] : ": 235781568" }}</span></h6>
                @if (isset($order->transactoion->orderShip))
                    <h6><span class="text-muted fw-normal">@lang("admin.transaction_invoice.shipment_no"):</span> {{ isset($order->transactoion->orderShip) ? $order->transactoion->orderShip->order_id : ": 6545645" }}</h6>
                @endif
                <h6 class="mb-0"><span class="text-muted fw-normal">@lang("admin.transaction_invoice.date"): </span><span id="contact-no"> {{ \Carbon\Carbon::parse($order->date)->format("d-m-Y H:i A") }}</span></h6>
            </div>
            <div class="flex-shrink-0 mt-sm-0 mt-3">
                <img src="images/logo.svg" class="card-logo card-logo-dark" alt="logo dark" height="90">
            </div>
            <div>
                <center>
                    <h4 style="padding-right:51px">@lang("admin.transaction_invoice.invoice_brif")</h4>
                </center>
            </div>
        </div>
        <div class="body">
            <div class="body-header">
                <div class="row g-3">
                    <div class="col-2">
                        <p class="text-muted mb-2 text-uppercase fw-semibold">@lang("admin.payment_method")</p>
                        <span class="badge badge-soft-success fs-11" id="payment-status">
                            {{ \App\Enums\PaymentMethods::getStatusWithClass($order->transaction->payment_method)["name"] }}
                        </span>
                    </div><!--end col-->
                </div>
            </div>
            <div class="body-table">
                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="table-responsive">
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
                                        <th scope="col">@lang("admin.transaction_invoice.products_table_header.product_details")</th>
                                        <th scope="col">@lang("admin.transaction_invoice.products_table_header.rate")</th>
                                        <th scope="col">@lang("admin.transaction_invoice.products_table_header.quantity")</th>
                                        <th scope="col">@lang("admin.transaction_invoice.products_table_header.amount")</th>
                                        <th scope="col">@lang("admin.transaction_invoice.products_table_header.tax_value")</th>
                                        <th scope="col">@lang("admin.transaction_invoice.products_table_header.total_with_tax")</th>
                                    </tr>
                                </thead>
                                <tbody id="products-list">
                                        @foreach ($order->orderProducts as $productItem)
                                            <tr>
                                                <td class="text-start">
                                                    <span class="fw-medium">{{ $productItem->product?->name }}</span>
                                                    <p class="text-muted mb-0">
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
                                <center>
                                    @lang("admin.transaction_invoice.not_found")
                                </center>

                        </div>
                        <div class="border-top border-top-dashed mt-2">
                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                <tbody>
                                    <tr>
                                        <td>@lang("admin.transaction_invoice.sub_total")</td>
                                        <td class="text-end">{{ $order->sub_total_in_sar }} @lang("translation.sar")</td>
                                    </tr>
                                    <tr>
                                        <td>@lang("admin.transaction_invoice.estimated_tax") ({{ $productItem->vat_percentage }}%)</td>
                                        <td class="text-end">{{ $order->total_vat_in_sar ? $order->total_vat_in_sar : 0 }} @lang("translation.sar")</td>
                                    </tr>
                                    @if($order->discount)
                                    <tr>
                                        <td>@lang("admin.transaction_invoice.discount") <small class="text-muted">(VELZON15)</small></td>
                                        <td class="text-end">- {{ $order->discount }} @lang("translation.sar")</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>@lang("admin.transaction_invoice.shipping_charge")</td>
                                        <td class="text-end">{{ $order->delivery_fees_in_sar_rounded }} @lang("translation.sar")</td>
                                    </tr>
                                    <tr class="border-top border-top-dashed fs-15">
                                        <th scope="row">@lang('admin.transaction_invoice.total_amount')</th>
                                        <th class="text-end">{{ $order->total_in_sar }} @lang("translation.sar")</th>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                    </div>
                    <!--end card-body-->
                </div><!--end col-->
            </div>
        </div>
    </div>
</body>
</html>