<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@lang("translation.invoice")</title>
  </head>
  <body>
    <div>
      <table width="660" align="center">
        <tbody
          align="center"
          border="0"
          cellpadding="0"
          cellspacing="0"
          width="660"
        >
          <tr>
            <td align="right" >
              <div>
                <p style="font-weight: bold; color: #9096ab">
                  @lang("admin.transaction_invoice.app_name")
                </p>
              </div>
              <div style="margin-bottom: 5px">
                <span style="color: #9096ab">@lang("admin.transaction_invoice.invoice_no")</span>
                <span style="font-weight: bold; color: #333"> #{{ $transaction->code ? $transaction->code : $transaction->id }} </span>
              </div>
              <div style="margin-bottom: 5px">
                <span style="color: #9096ab">@lang("admin.transaction_invoice.tax_no")</span>
                <span style="font-weight: bold; color: #333"> {{ isset($settings["tax_no"]) && !empty($settings["tax_no"]) ? $settings["tax_no"] : ": 235781568" }} </span>
              </div>
              @if(isset($transactoion->orderShip))
                <div style="margin-bottom: 5px">
                  <span style="color: #9096ab">@lang("admin.transaction_invoice.shipment_no")</span>
                  <span style="font-weight: bold; color: #333"> {{ isset($transactoion->orderShip) ? $transactoion->orderShip->order_id : null }} </span>
                </div>
              @endif
              <div style="margin-bottom: 5px">
                <span style="color: #9096ab">@lang("admin.transaction_invoice.date"):</span>
                <span
                  style="
                    direction: ltr;
                    font-weight: bold;
                    color: #333;
                    text-align: left;
                    display: inline-block;
                  "
                >
                {{ \Carbon\Carbon::parse($transaction->date)->format("d-m-Y H:i A") }}
                </span>
              </div>
            </td>
            <td align="left" >
              <img
              style="width: 250px"
                src="images/logo.svg"
                alt="saudi-dates"
                
                data-bit="iit"
              />
            </td>
          </tr>
        </tbody>
      </table>
      <br>
      <table width="660" align="center">
        <tbody align="center" border="0" cellpadding="0" cellspacing="0" width="660">
          <tr align="center">
            <td align="center">
              <div>
                <p style="text-align: center; font-weight: bold; color: #333">
                  @lang("admin.transaction_invoice.invoice_brif")
                </p>
              <br>
              </div>
              <hr />
            </td>
          </tr>
        </tbody>
      </table>
      <br>
      <table width="660">
        <tbody
          align="right"
          border="0"
          cellpadding="0"
          cellspacing="0"
          width="660"
        >
          <tr width="660">
            <td width="200">
              <div>
                <p style="font-weight: bold; color: #9096ab">@lang("admin.transaction_invoice.bill_info")</p>
              </div>
              <div style="margin-bottom: 5px">
                <p class="text-muted mb-1" id="billing-address-line-1">@lang("admin.transaction_invoice.client_sale"): {{ $transaction->customer->name }}</p>
                <p class="text-muted mb-1"><span>@lang("admin.transaction_invoice.phone"): </span><span id="billing-phone-no">{{ $transaction->customer->phone }}</span></p>
              </div>
            </td>
            <td width="260">
              <div>
                <p style="font-weight: bold; color: #9096ab">@lang("admin.transaction_invoice.ship_info")</p>
              </div>
              <div style="margin-bottom: 5px">
                <p class="text-muted mb-1" id="shipping-name">@lang("admin.transaction_invoice.client_name"): {{ $transaction->addresses->first_name }} {{ $transaction->addresses->last_name }}</p>
                <p class="text-muted mb-1" id="shipping-address-line-1">@lang("admin.transaction_invoice.address"): {{ $transaction->addresses->description }}</p>
                <p class="text-muted mb-1"><span id="shipping-phone-no">@lang("admin.transaction_invoice.phone"): {{ $transaction->addresses->phone }}</span></p>
              </div>
            </td>
            <td width="120">
              <div>
                <p style="font-weight: bold; white-space:nowrap; color: #9096ab">@lang("admin.payment_method")</p>
              </div>
              <div style="margin-bottom: 5px">
                <span
                  style="
                    background-color: #e5f8f5;
                    padding: 5px 9px;
                    border-radius: 5px;
                    color: #68c9a8;
                  "
                >
                {{ \App\Enums\PaymentMethods::getStatusWithClass($transaction->payment_method)["name"] }}
                </span>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <br>
      @if($transaction->orders->count() > 0)
        @foreach ($transaction->orders as $order)
          <table width="660" align="center">
            <tbody
              align="right"
              border="0"
              cellpadding="0"
              cellspacing="0"
              width="660"
            >
              <tr>
                <td>
                  <div>
                    <span>@lang("admin.vendor_name"):</span>
                    <span>{{ $order->vendor->name }}</span>
                  </div>
                </td>
                <td>
                  <div>
                    <span>@lang("translation.tax_num"):</span>
                    <span>{{ $order->vendor->tax_num }}</span>
                  </div>
                </td>
                <td>
                  <div>
                    <span>@lang("admin.transaction_invoice.invoice_no"):</span>
                    <span>#{{ $order->id }}</span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          @foreach ($order->orderProducts as $productItem)
            <table width="660" align="center" style="margin-top: 20px">
              <thead>
                <tr
                  style="background-color: #eee"
                  align="center"
                  border="0"
                  width="660"
                >
                  <th style="padding: 5px 10px">@lang("admin.transaction_invoice.products_table_header.product_details")</th>
                  <th style="padding: 5px 10px">@lang("admin.transaction_invoice.products_table_header.rate")</th>
                  <th style="padding: 5px 10px">@lang("admin.transaction_invoice.products_table_header.quantity")</th>
                  <th style="padding: 5px 10px">@lang("admin.transaction_invoice.products_table_header.amount")</th>
                  <th style="padding: 5px 10px">@lang("admin.transaction_invoice.products_table_header.tax_value")</th>
                  <th style="padding: 5px 10px">@lang("admin.transaction_invoice.products_table_header.total_with_tax")</th>
                </tr>
              </thead>
              <tbody
                align="center"
                border="0"
                cellpadding="0"
                cellspacing="0"
                width="660"
              >
                <tr>
                  <td>
                    <div style="text-align: right">{{ $productItem->product?->name }}</div>
                    <div style="text-align: right">
                      <span style="color: #9096ab">@lang("admin.transaction_invoice.products_table_header.barcode"):</span>
                      <span style="color: #9096ab">{{$productItem->product?->sku}}</span>
                    </div>
                  </td>
                  <td>{{ $productItem->unit_price_in_sar_rounded }} @lang("translation.sar")</td>

                  <td>{{ $productItem->quantity }}</td>
                  <td>{{ $productItem->total_without_vat_in_sar_rounded }} @lang("translation.sar")</td>
                  <td>{{ $productItem->vat_rate_in_sar_rounded }} @lang("translation.sar") ({{ $productItem->vat_percentage }}%)</td>
                  <td>{{ $productItem->total_in_sar_rounded }} @lang("translation.sar")</td>
                </tr>
              </tbody>
            </table>
          @endforeach
        @endforeach
      @endif
      <br>
      <div>
        <div style="width: 300px; margin-right: auto; text-align: left">
          <div>
              <span style="display: inline-block;margin-left: auto; width: 150px; text-align: right">@lang("admin.transaction_invoice.sub_total")</span>
              <span style="display: inline-block;margin-right: auto;  width: 150px; text-align: left">{{ $transaction->sub_total_in_sar_rounded }} @lang("translation.sar")</span>
          </div>
        </div>
  
        <div style="width: 300px; margin-right: auto; text-align: left">
          <div>
              <span style="display: inline-block;margin-left: auto; width: 150px; text-align: right">@lang("admin.transaction_invoice.estimated_tax")</span>
              <span style="display: inline-block;margin-right: auto;  width: 150px; text-align: left">({{ isset($settings["tax"]) && !empty($settings["tax"]) ? $settings["tax"] : "15.00"}}%) {{ $transaction->total_vat_in_sar_rounded }}@lang("translation.sar")</span>
          </div>
        </div>

        @if($transaction->discount)
          <div style="width: 300px; margin-right: auto; text-align: left">
            <div>
                <span style="display: inline-block;margin-left: auto; width: 150px; text-align: right">@lang("admin.transaction_invoice.discount")</span>
                <span style="display: inline-block;margin-right: auto;  width: 150px; text-align: left">{{ $transaction->discount_in_sar_rounded }} @lang("translation.sar")</span>
            </div>
          </div>
        @endif

        @if($transaction->wallet_deduction)
          <div style="width: 300px; margin-right: auto; text-align: left">
            <div>
                <span style="display: inline-block;margin-left: auto; width: 150px; text-align: right">@lang("admin.transaction_invoice.sub_from_wallet")</span>
                <span style="display: inline-block;margin-right: auto;  width: 150px; text-align: left">{{ $transaction->wallet_deduction_in_sar_rounded }} @lang("translation.sar")</span>
            </div>
          </div>
        @endif

        <div style="width: 300px; margin-right: auto; text-align: left">
          <div>
              <span style="display: inline-block;margin-left: auto; width: 150px; text-align: right">@lang("admin.transaction_invoice.sub_total_without_vat")</span>
              <span style="display: inline-block;margin-right: auto;  width: 150px; text-align: left">
                {{ $transaction->sub_total_with_vat_in_sar_rounded ? $transaction->sub_total_with_vat_in_sar_rounded : 0 }}
              </span>
          </div>
        </div>

        <div style="width: 300px; margin-right: auto; text-align: left">
          <div>
              <span style="display: inline-block;margin-left: auto; width: 150px; text-align: right">@lang("admin.transaction_invoice.vat_percentage")</span>
              <span style="display: inline-block;margin-right: auto;  width: 150px; text-align: left">{{ $transaction->vat_percentage ? $transaction->vat_percentage : 0 }}%</span>
          </div>
        </div>

        <div style="width: 300px; margin-right: auto; text-align: left">
          <div>
              <span style="display: inline-block;margin-left: auto; width: 150px; text-align: right">@lang("admin.transaction_invoice.vat_rate")</span>
              <span style="display: inline-block;margin-right: auto;  width: 150px; text-align: left">{{ $transaction->vat_rate ? $transaction->vat_rate : 0 }} @lang("translation.sar")</span>
          </div>
        </div>

        <div style="width: 300px; margin-right: auto; text-align: left">
          <div>
              <span style="display: inline-block;margin-left: auto; width: 150px; text-align: right">@lang("admin.transaction_invoice.shipping_charge")</span>
              <span style="display: inline-block;margin-right: auto;  width: 150px; text-align: left">{{ $transaction->delivery_fees_in_sar_rounded }} @lang("translation.sar")</span>
          </div>
        </div>

        <hr>
        
        <div style="width: 300px; margin-right: auto; text-align: left">
          <div>
              <span style="display: inline-block;margin-left: auto; width: 150px; text-align: right">@lang('admin.transaction_invoice.total_amount')</span>
              <span style="display: inline-block;margin-right: auto;  width: 150px; text-align: left">{{ $transaction->total_amount_rounded }} @lang("translation.sar")</span>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>