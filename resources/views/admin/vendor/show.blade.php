@extends('admin.layouts.master')
@section('title') @lang('admin.vendors_show') @endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="javascript:void(0);" class="row g-3">

                        <div class="col-md-6">
                            <label for="username" class="form-label">@lang('admin.vendor_owner_name')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{$vendor->owner->name}}">
                        </div>

                        {{-- @foreach(config('app.locales') AS $locale) --}}
                            <div class="col-md-6">
                                <label for="username" class="form-label">@lang('admin.vendor_name')</label>
                                <input disabled="disabled" readonly type="text" class="form-control" value="{{$vendor->name}}">
                            </div>
                        {{-- @endforeach --}}

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_phone')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" name="street" value="{{ $vendor->owner->phone }}" id="street">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_second_phone')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" name="street" value="{{ $vendor->second_phone }}" id="street">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.email')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" name="street" value="{{ $vendor->owner->email }}" id="street">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_website')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" name="street" value="{{ $vendor->website }}" id="street">
                        </div>

                        <div class="col-md-6">
                            <label for="username" class="form-label">@lang('admin.vendor_description')</label>
                            <textarea disabled="disabled" readonly class="form-control" name="desc" rows="3">{{ $vendor->desc}}</textarea>
                        </div>
                    
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_address')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" name="street" value="{{ $vendor->street }}" id="street">
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_bank')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $vendor->bank->name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_bank_number')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $vendor->bank_num }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_tax_number')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $vendor->tax_num }}">
                        </div>
                     
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_iban') <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text">SA</div>
                                <input disabled="disabled" readonly type="text" class="form-control" value="{{substr($vendor->ipan, 0, 2) == 'SA' ? str_replace('SA','',$vendor->ipan):$vendor->ipan }}" >

                            </div>                        
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_commercial_register_date')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{Alkoumi\LaravelHijriDate\Hijri::Date('Y-m-d',$vendor->crd)}}">
                        </div>
                      
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_commission')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $vendor->commission }}">
                        </div>
                       
                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang("admin.beez_id")</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $vendor->beezConfig ? $vendor->beezConfig->beez_id : trans("admin.not_found") }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_is_international')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="@if($vendor->is_international == 1) @lang('admin.yes') @else @lang('admin.no') @endif">
                        </div>
                        

                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_logo')</label>
                            <div class="d-flex align-items-center mt-4">
                                <div class="flex-shrink-0">
                                    <a href="{{ URL::asset($vendor->logo) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_commercial_register')</label>
                            <div class="d-flex align-items-center mt-4">
                                <div class="flex-shrink-0">
                                    <a href="{{ URL::asset($vendor->cr) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_broc')</label>
                            <div class="d-flex align-items-center mt-4">
                                <div class="flex-shrink-0">
                                    <a href="{{ URL::asset($vendor->broc) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_tax_certificate')</label>
                            <div class="d-flex align-items-center mt-4">
                                <div class="flex-shrink-0">
                                    <a href="{{ URL::asset($vendor->tax_certificate) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_iban_certificate')</label>
                            <div class="d-flex align-items-center mt-4">
                                <div class="flex-shrink-0">
                                    <a href="{{ URL::asset($vendor->iban_certificate) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                </div>
                            </div>
                        </div>
                      
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
