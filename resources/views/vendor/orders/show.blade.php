@extends('vendor.layouts.master')
@section('title')
    @lang('translation.order-details')
@endsection
@section('content')
    @include('sweetalert::alert')

    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.orders')
        @endslot
        @slot('title')
            @lang('translation.order_details')
        @endslot
    @endcomponent


<!--  -->

    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">@lang('translation.order_id') #{{$row->code}}</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route("vendor.orders.invoice", $row->id) }}" class="btn btn-primary btn-sm"><i
                                    class="ri-download-2-fill align-middle me-1"></i>@lang('admin.transaction_invoice.invoice_brif')</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle table-borderless mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">@lang('translation.product_details')</th>
                                    <th scope="col">@lang('translation.product_price')</th>
                                    <th scope="col">@lang('translation.quantity')</th>
                                    <th scope="col">@lang('translation.reviews')</th>
                                    <th scope="col" class="text-end">@lang('translation.price')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($row->products as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                <img src="{{ URL::asset($product->image) }}" alt=""
                                                    class="img-fluid d-block">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="fs-15"><a href="{{URL::asset('/vendor/products/'.$product->id)}}"
                                                        class="link-primary">{{$product->name}}</a></h5>
                                                <p class="text-muted mb-0">@lang('translation.quantity_type'): <span class="fw-medium">{{$product?->quantity_type?->name}}</span>
                                                </p>
                                                <p class="text-muted mb-0">@lang('translation.type'): <span class="fw-medium">{{$product?->type?->name}}</span></p>
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
                                    <td class="fw-medium text-end">{{ amountInSar($product->pivot->quantity * $product->pivot->unit_price) }} @lang('translation.sar')</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">@lang('translation.order_status')</h5>
                        {{-- <div class="flex-shrink-0 mt-2 mt-sm-0">
                            <a href="javasccript:void(0;)" class="btn btn-soft-primary btn-sm mt-2 mt-sm-0"><i
                                    class="ri-map-pin-line align-middle me-1"></i> Change Address</a>
                            <a href="javasccript:void(0;)" class="btn btn-soft-secondary btn-sm mt-2 mt-sm-0"><i
                                    class="mdi mdi-archive-remove-outline align-middle me-1"></i> Cancel Order</a>
                        </div> --}}
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
                                                <h6 class="fs-15 mb-0 fw-semibold">@lang('translation.order_placed') - <span
                                                        class="fw-normal">{{$row->created_at->toFormattedDateString() }} <small class="text-muted">{{$row->created_at->format('g:i A')}}</small></span></h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body ms-2 ps-5 pt-0">
                                        <h6 class="mb-1">@lang('translation.an_order_has_been_placed')</h6>
                                        <p class="text-muted">{{$row->created_at->format('l') }}, {{$row->created_at->toFormattedDateString() }} - {{$row->created_at->format('g:i A')}}</p>

                                        
                                    </div>
                                </div>
                            </div>
                            @foreach($row->steps as $step)
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingOne">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
                                        href="#collapseOne{{$step->id}}" aria-expanded="true" aria-controls="collapseOne{{$step->id}}">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-primary rounded-circle">
                                                    @if($step->status == 'shipping_done')
                                                    <i class="mdi mdi-package-variant"></i>
                                                    @endif
                                                    @if($step->status == 'in_delivery')
                                                    <i class="ri-takeaway-fill"></i>
                                                    @endif
                                                    @if($step->status == 'canceled')
                                                    <i class="ri-close-circle-fill"></i>
                                                    @endif
                                                    @if($step->status == 'completed')
                                                    <i class="ri-checkbox-circle-fill"></i>
                                                    @endif
                                                    {{-- @if($step->status == 'refund')
                                                    <i class=" ri-refund-2-line"></i>
                                                    @endif --}}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-15 mb-0 fw-semibold">@lang('translation.'.$step->status) - <span
                                                        class="fw-normal">{{$row->created_at->format('l'); }} , {{$step->created_at->toFormattedDateString() }} <small class="text-muted">{{$step->created_at->format('g:i A')}}</small></span></h6>
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
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xl-3">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0"><i
                                class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i> @lang("admin.shipping_info")</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/uetqnvvg.json" trigger="loop"
                            colors="primary:#25a0e2,secondary:#00bd9d" style="width:80px;height:80px"></lord-icon>
                        <h5 class="fs-16 mt-2">@lang("vendors.shipping_info.title")</h5>
                        @if (!empty($row->transaction->orderShip))
                            {{-- <p class="text-muted mb-0">@lang("vendors.shipping_info.tracking_id"): {{ $row->transaction->orderShip->gateway_tracking_id }}</p> --}}
                            <p class="text-muted mb-0">@lang("vendors.shipping_info.status"): {{ \App\Enums\OrderStatus::getStatusList()[$row->transaction->status] }}</p>
                        @endif
                        <p class="text-muted mb-0">@lang('translation.payment_method') : {{ \App\Enums\PaymentMethods::getStatusList()[$row->transaction->payment_method] }}</p>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
