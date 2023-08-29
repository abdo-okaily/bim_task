@extends('admin.layouts.master')
@section('title')
    @lang('admin.coupons.update')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang('admin.edit')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('PUT')
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="coupons-arabic-info" role="tabpanel" aria-labelledby="coupons-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name_ar">@lang('admin.coupons.title_ar')</label>
                                                        <input type="text" name="title_ar" class="form-control" id="title_ar" value="{{ $coupon->getTranslation('title', 'ar') }}" placeholder="{{ trans('admin.coupons.title_ar') }}">
                                                        @error('title_ar')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="title_en">@lang('admin.coupons.title_en')</label>
                                                        <input type="text" name="title_en" class="form-control" id="title_en" value="{{ $coupon->getTranslation('title', 'en') }}" placeholder="{{ trans('admin.coupons.title_en') }}">
                                                        @error('title_en')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="code">@lang('admin.coupons.code')</label>
                                                        <input type="text" name="code" class="form-control" id="code" value="{{ $coupon->code }}" placeholder="{{ trans('admin.coupons.code') }}">
                                                        @error('code')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="coupon_type">@lang('admin.coupons.coupon_type')</label>
                                                        <select onchange="handle_coupon_type(this);" class="select2 form-control" name="coupon_type" id="select2_coupon_type">
                                                            <option selected value=""> @lang("admin.coupons.coupon_type")</option>
                                                            @foreach ($couponTypes as $couponType)
                                                                <option @if($coupon->coupon_type == $couponType["value"]) selected @endif value="{{ $couponType["value"] }}">{{ $couponType["name"] }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('coupon_type')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="amount">@lang('admin.coupons.amount')</label>
                                                        <input type="number" min="1" step="1" name="amount" class="form-control" value="{{ $coupon->amount }}" id="amount" placeholder="{{ trans('admin.coupons.amount') }}">
                                                        @error('amount')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="discount_type">@lang('admin.coupons.discount_type')</label>
                                                        <select class="select2 form-control" name="discount_type" id="select2_discount_type">
                                                            @foreach ($discountTypes as $type)
                                                                <option @if($coupon->discount_type == $type["value"]) selected @endif value="{{ $type["value"] }}"> {{ $type["name"] }} </option>
                                                            @endforeach
                                                        </select>
                                                        @error('discount_type')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="minimum_order_amount">@lang('admin.coupons.minimum_order_amount')</label>
                                                        <input type="number" min="1" step="1" name="minimum_order_amount" class="form-control" value="{{ $coupon->minimum_order_amount }}" id="minimum_order_amount" placeholder="{{ trans('admin.coupons.minimum_order_amount') }}">
                                                        @error('minimum_order_amount')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="maximum_discount_amount">@lang('admin.coupons.maximum_discount_amount')</label>
                                                        <input type="number" min="1" step="1" name="maximum_discount_amount" class="form-control" value="{{ $coupon->maximum_discount_amount }}" id="maximum_discount_amount" placeholder="{{ trans('admin.coupons.maximum_discount_amount') }}">
                                                        @error('maximum_discount_amount')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-lg-6" id="couponVendors" @if($coupon->coupon_type != 'vendor') style="display: none;" @endif >
                                                    <div class="mb-3">
                                                        <label class="form-label" for="vendors">@lang('admin.vendor_name')</label>
                                                        <select class="form-control" name="vendors[]" id="vendors" data-choices data-choices-removeItem multiple>
                                                            @foreach($vendors AS $vendor)
                                                                <option @if($coupon->coupon_type == 'vendor' && in_array($vendor->id,$coupon->CouponMeta->related_ids)) selected @endif value="{{ $vendor->id }}">{{ $vendor->vendorName }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('vendors')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" id="couponProducts" @if($coupon->coupon_type != 'product') style="display: none;" @endif >
                                                    <div class="mb-3">
                                                        <label class="form-label" for="products">@lang('admin.products.title')</label>
                                                        <select class="form-control" name="products[]" id="couponProductsSelect" multiple="multiple">
                                                            @foreach($products AS $product)
                                                                <option value="{{ $product->id }}" selected>{{ $product->productName }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('products')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="maximum_redemptions_per_user">@lang('admin.coupons.maximum_redemptions_per_user')</label>
                                                        <input type="number" min="0" step="1" name="maximum_redemptions_per_user" class="form-control" value="{{ $coupon->maximum_redemptions_per_user }}" id="maximum_redemptions_per_user" placeholder="{{ trans('admin.coupons.maximum_redemptions_per_user') }}">
                                                        @error('maximum_redemptions_per_user')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="maximum_redemptions_per_coupon">@lang('admin.coupons.maximum_redemptions_per_coupon')</label>
                                                        <input type="text" min="0" step="1" name="maximum_redemptions_per_coupon" class="form-control" value="{{ $coupon->maximum_redemptions_per_coupon }}" id="maximum_redemptions_per_coupon" placeholder="{{ trans('admin.coupons.maximum_redemptions_per_coupon') }}">
                                                        @error('maximum_redemptions_per_coupon')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="start_at">@lang('admin.coupons.start_at')</label>
                                                        <input value="{{ $coupon->start_at }}" name="start_at" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-minDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.from')">
                                                        @error('start_at')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="expire_at">@lang('admin.coupons.expire_at')</label>
                                                        <input value="{{ $coupon->expire_at }}" name="expire_at" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-minDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.to')">
                                                        @error('expire_at')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Of Arabic Info tab pane -->
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="submit" class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                        <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                        @lang('admin.coupons.update')
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </div>
    </div>
    <style>
        #select2-couponProductsSelect-container    {
            display: flex;
            flex-wrap: wrap;
        }
        #select2-couponProductsSelect-container li button{
            position: relative;
        }
        #select2-couponProductsSelect-container li {
            position: relative;
            width: fit-content;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-right: unset;
            flex-direction: row-reverse;
        }
        .select2-selection__choice__display{
            display: block;
        }
    </style>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('script-bottom')
    <script>
        function handle_coupon_type(item)
        {
            let type = $(item).val();
            if(type == "vendor")
            {
                $('#couponVendors').fadeIn('slow');
                $('#couponProducts').fadeOut('slow');

            }
            else if (type == "product")
            {
                $('#couponProducts').fadeIn('slow');
                $('#couponVendors').fadeOut('slow');
            }
            else
            {
                $('#couponProducts').fadeOut('slow');
                $('#couponVendors').fadeOut('slow');
            }
        }

        $(document).ready(function ()
        {
            $('#couponProductsSelect').select2({
                ajax: {
                    url: function (params)
                    {
                        return "{{ URL::asset('/admin') }}/coupons/products/" + params.term;
                    },
                    data: function (params)
                    {
                        return {};
                    },
                    dataType: 'json'
                }
            });
        });
    </script>
@endsection