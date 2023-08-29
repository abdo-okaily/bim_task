@extends('admin.layouts.master')
@section('title')
    @lang('admin.transaction_show')
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">
                            @lang('admin.transaction_id') #{{ $transaction->code }}
                        </h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route("admin.transactions.invoice", $transaction->id) }}" class="btn btn-primary btn-sm">
                                <i class="ri-download-2-fill align-middle me-1"></i> @lang('admin.transaction_invoice.invoice_brif')
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle table-borderless mb-0">
                            <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">@lang('admin.products.product_details')</th>
                                <th scope="col">@lang('admin.products.product_price')</th>
                                <th scope="col">@lang('admin.products.product_quantity')</th>
                                <th scope="col">@lang('admin.products.product_reviews')</th>
                                <th scope="col" class="text-end">@lang('admin.products.product_price_final')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transaction->orders As $order)
                                @foreach($order->products As $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                    <img src="{{ URL::asset($product->image) }}" class="img-fluid d-block">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="fs-15">
                                                        <a href="{{ route("admin.products.show", $product->id) }}" class="link-primary">
                                                            {{$product->name}}
                                                        </a>
                                                    </h5>
                                                    <p class="text-muted mb-0">
                                                        @lang('translation.quantity_type'): <span class="fw-medium">{{$product?->quantity_type?->name}}</span>
                                                    </p>
                                                    <p class="text-muted mb-0">
                                                        @lang('translation.type'): <span class="fw-medium">{{$product?->type?->name}}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ amountInSar($product->pivot->unit_price) }} @lang('translation.sar')</td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td>
                                            <div class="text-warning fs-15">
                                                    <?php $avg=round($product->reviews()->avg('rate')); ?>
                                                    <?php $non_avg=5-$avg; ?>
                                                @for($i= 0; $i < $avg ; $i++)
                                                    <i class="ri-star-fill"></i>
                                                @endfor
                                                @for($i= 0; $i < $non_avg ; $i++)
                                                    <i class="ri-star-line"></i>
                                                @endfor
                                            </div>
                                        </td>
                                        <td class="fw-medium text-end">{{ amountInSar($product->pivot->total) }} @lang('translation.sar')</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">@lang('admin.transaction_status')</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="profile-timeline">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingOne">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
                                       href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-primary rounded-circle">
                                                    <i class="ri-shopping-bag-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-15 mb-0 fw-semibold">@lang('admin.order_placed') - <span
                                                            class="fw-normal">{{$transaction->created_at->toFormattedDateString() }} <small class="text-muted">{{$transaction->created_at->format('g:i A')}}</small></span></h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body ms-2 ps-5 pt-0">
                                        <h6 class="mb-1">@lang('admin.an_order_has_been_placed')</h6>
                                        <p class="text-muted">{{$transaction->created_at->format('l') }}, {{$transaction->created_at->toFormattedDateString() }} - {{$transaction->created_at->format('g:i A')}}</p>


                                    </div>
                                </div>
                            </div>
                            @foreach($transaction->TransactionLogs as $step)
                                <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingOne">
                                        <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
                                           href="#collapseOne{{$step->id}}" aria-expanded="true" aria-controls="collapseOne{{$step->id}}">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-primary rounded-circle">
                                                        @if($step->new_status == 'shipping_done')
                                                            <i class="mdi mdi-package-variant"></i>
                                                        @endif
                                                        @if($step->new_status == 'in_delivery')
                                                            <i class="ri-takeaway-fill"></i>
                                                        @endif
                                                        @if($step->new_status == 'canceled')
                                                            <i class="ri-close-circle-fill"></i>
                                                        @endif
                                                        @if($step->new_status == 'completed')
                                                            <i class="ri-checkbox-circle-fill"></i>
                                                        @endif
                                                        @if($step->new_status == 'refund')
                                                            <i class=" ri-refund-2-line"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-15 mb-0 fw-semibold">@lang('admin.'.$step->new_status) - <span class="fw-normal">{{ $transaction->created_at->format('l') }} , {{ $step->created_at->toFormattedDateString() }} <small class="text-muted">{{ $step->created_at->format('g:i A') }}</small></span></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--end accordion-->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0">
                            <i class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i> @lang("admin.shipping_info")
                        </h5>
                        @if(!empty($transaction->orderShip) && !empty($transaction->orderShip->gateway_tracking_id))
                            <div class="flex-shrink-0">
                                <a href="{{ config("shipping.bezz.tracking_url") . $transaction->orderShip->gateway_tracking_id }}" target="_blanck" class="badge badge-soft-primary fs-11">
                                    @lang("admin.track_shipment")
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/uetqnvvg.json" trigger="loop"
                                   colors="primary:#25a0e2,secondary:#00bd9d" style="width:80px;height:80px"></lord-icon>
                        <h5 class="fs-16 mt-2">
                            @if (!empty($transaction->orderShip))
                                @lang("admin.bezz")
                            @else
                                @lang("admin.no_shipment")
                            @endif
                        </h5>
                        <p class="text-muted mb-0">@lang("vendors.shipping_info.status"): {{ \App\Enums\OrderStatus::getStatusList()[$transaction->status] }}</p>
                        <p class="text-muted mb-0">
                            @if (!empty($transaction->orderShip->gateway_tracking_id))
                                @lang("admin.tracking_id"): {{ $transaction->orderShip->gateway_tracking_id }}
                            @else
                                @lang("admin.transaction_id"): {{ $transaction->id }}
                            @endif
                        </p>
                        <p class="text-muted mb-0">@lang('admin.payment_method') : {{ \App\Enums\PaymentMethods::getStatusList()[$transaction->payment_method] }}</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0">@lang('admin.customer_details')</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.customers.show', ['user' => $transaction->customer]) }}" class="link-secondary">{{ $transaction->customer->name }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 vstack gap-3">
                        <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $transaction->customer->email }}</li>
                        <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $transaction->customer->phone }}</li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i>@lang('admin.address_data')</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                        <li class="fw-medium fs-14">{{ $transaction->addresses->first_name }} {{ $transaction->addresses->last_name }}</li>
                        <li>@lang('admin.phone') : {{ $transaction?->addresses?->phone }}</li>
                        <li>@lang('admin.countries.single_title') : {{ $transaction?->addresses?->country?->name }}</li>
                        <li>@lang('admin.areas.single_title') : {{ $transaction?->addresses?->area?->name }}</li>
                        <li>@lang('admin.cities.single_title') : {{ $transaction?->addresses?->city?->name }}</li>
                        <li>@lang('admin.address_description') : {{ $transaction?->addresses?->description }}</li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i>@lang('admin.payment_data')</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.transaction_id') : </p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">#{{ $transaction->id }}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.payment_method') : </p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{ App\Enums\PaymentMethods::getStatus($transaction->payment_method) }}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.total') : </p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{ $transaction->total_in_sar_rounded }} @lang('translation.sar')</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.delivery_fees') : </p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{ $transaction->delivery_fees_in_sar }} @lang('translation.sar')</h6>
                        </div>
                    </div>
                    @if($transaction->discount)
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.coupon-discount') : </p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{ $transaction->discount_in_sar_rounded }} @lang('translation.sar')</h6>
                        </div>
                    </div>
                    @endif
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.paid_amount') : </p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{ $transaction->total_amount_rounded }} @lang('translation.sar')</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ url('assets/js/app.min.js') }}"></script>
@endsection
