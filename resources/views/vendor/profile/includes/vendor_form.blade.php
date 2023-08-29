<form action="{{route('vendor.update-vendor')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">


        <div class="col-lg-6">
            <div class="mb-3">
                <label for="firstnameInput" class="form-label">@lang('translation.owner_store_name')<span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" name="store_name" id="firstnameInput"
                    placeholder="@lang('translation.store_name_placeholder')" value="{{$row->name}}" disabled>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <label for="firstnameInput" class="form-label">@lang('translation.store_name')<span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" name="store_name" id="firstnameInput"
                    placeholder="@lang('translation.store_name_placeholder')" value="{{$row->my_vendor->name}}" disabled>
            </div>
        </div>


        <div class="col-lg-6">
            <div class="mb-3">
                <label for="firstnameInput" class="form-label">@lang('translation.phone')<span
                        class="text-danger">*</span></label>
                <input type="number" class="form-control" name="store_name" id="firstnameInput"
                    placeholder="@lang('translation.phone_placeholder')" value="{{$row->phone}}" disabled>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <label for="firstnameInput" class="form-label">@lang('translation.second_phone')<span
                        class="text-danger">*</span></label>
                <input type="number" class="form-control" name="store_name" id="firstnameInput"
                    placeholder="@lang('translation.second_phone_placeholder')" value="{{$row->my_vendor->second_phone}}" disabled>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <label for="firstnameInput" class="form-label">@lang('translation.email')<span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" name="store_name" id="firstnameInput"
                    placeholder="@lang('translation.email_placeholder')" value="{{$row->email}}" disabled>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <label for="firstnameInput" class="form-label">@lang('translation.website')</label>
                <input type="text" class="form-control" name="store_name" id="firstnameInput"
                    placeholder="@lang('translation.website_placeholder')" value="{{$row->my_vendor->website}}" disabled>
            </div>
        </div>
       
        <div class="col-md-6 mb-3">
            <label for="username" class="form-label">@lang('translation.address')</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                name="street" value="{{ old('name',$row->my_vendor->street) }}" id="street"
                placeholder="@lang('translation.enter_address')" disabled>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback">
                @lang('translation.please_enter_street')
            </div>
        </div>

        <div class="col-md-6">
            <label for="username" class="form-label">@lang('translation.desc')</label>
            <textarea disabled="disabled" readonly class="form-control" name="desc" rows="3">{{ $row->my_vendor->desc}}</textarea>
        </div>
                
        {{-- <div class="col-md-4 mb-3">
            <label for="username" class="form-label">@lang('translation.bank_name') <span
                    class="text-danger">*</span></label>
            <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                name="bank_name" value="{{ old('bank_name',$row->my_vendor->bank_name) }}" id="bank_name"
                placeholder="@lang('translation.bank_name_placeholder')" required disabled>
            @error('bank_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback">
                @lang('translation.please_enter_bank_name')
            </div>
        </div> --}}

        <div class="col-md-6 mb-3">
            <label for="bank_id" class="form-label">@lang('admin.vendor_bank') <span class="text-danger">*</span></label>
            <select class="form-control" name="bank_id"  disabled>
                
                @if($row->my_vendor->bank)
                    <option selected value="{{ $row->my_vendor->bank->id }}">
                        {{ $row->my_vendor->bank->getTranslation('name', 'ar') }} - {{ $row->my_vendor->bank->getTranslation('name', 'en') }}
                    </option>
                @else

                <option selected value="">
                    @lang("vendors.registration.choose_bank_name")
                </option>
                @endif

                @if ($banks->count() > 0)
                    @foreach ($banks as $bank)
                        <option value="{{ $bank->id }}">
                            {{ $bank->getTranslation('name', 'ar') }} - {{ $bank->getTranslation('name', 'en') }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('bank_id')
                <span class="invalid-feedback" role="alert">
                </span>
                    <strong>{{ $message }}</strong>
            @enderror
        </div>

        {{-- <div class="col-md-6 mb-3">
            <label for="bank_id" class="form-label">@lang('translation.bank_name') <span class="text-danger">*</span></label>
            <select class="form-control" name="bank_id" disabled>
                <option selected value="">
                    @lang("vendors.registration.choose_bank_name")
                </option>
                @if ($banks->count() > 0)
                    @foreach ($banks as $bank)
                        @if($row->vendor->bank_id && $row->vendor->bank_id == $bank->id)
                            <option selected value="{{ $bank->id }}">
                                {{ $bank->getTranslation('name', 'ar') }} - {{ $bank->getTranslation('name', 'en') }}
                            </option>
                        @else
                            <option value="{{ $bank->id }}">
                                {{ $bank->getTranslation('name', 'ar') }} - {{ $bank->getTranslation('name', 'en') }}
                            </option>
                        @endif
                    @endforeach
                @endif
            </select>
            @error('bank_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div> --}}

        

        <div class="col-md-6 mb-3">
            <label for="username" class="form-label">@lang('translation.bank_num') <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('bank_num') is-invalid @enderror"
                name="bank_num" value="{{ old('bank_num',$row->my_vendor->bank_num) }}" id="bank_num"
                placeholder="@lang('translation.bank_num_placeholder')" required disabled>
            @error('bank_num')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback">
                @lang('translation.please_enter_bank_num')
            </div>
        </div>


        <div class="col-md-6 mb-3">
            <label for="username" class="form-label">@lang('translation.ipan') <span
                    class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group-text">SA</div>
                <input disabled="disabled" readonly type="text" class="form-control" value="{{substr($row->my_vendor->ipan, 0, 2) == 'SA' ? str_replace('SA','',$row->my_vendor->ipan):$row->my_vendor->ipan }}" >

                @error('ipan')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="invalid-feedback">
                    @lang('translation.please_enter_ipan')
                </div>
            </div>                        
        </div>

    
        <div class="col-md-6 mb-3">
            <label for="tax_num" class="form-label">@lang('translation.tax_num') <span
                    class="text-danger">*</span></label>
            <input type="number" class="form-control @error('tax_num') is-invalid @enderror"
                name="tax_num" value="{{ old('tax_num',$row->my_vendor->tax_num) }}" id="tax_num"
                placeholder="@lang('translation.tax_num_placeholder')" required disabled>
            @error('tax_num')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback">
                @lang('translation.please_enter_ipan')
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label for="inputAddress2" class="form-label">@lang('translation.crd_date')</label>
            <input disabled="disabled" readonly type="text" class="form-control" value="{{ date('Y-m-d', strtotime($row->my_vendor->crd)) }}">
        </div>
      


        <div class="row justify-center">
            <div class="col-lg-6" >
                <div class="card">
                    <div class="card-header">
                        <label for="username" class="form-label">@lang('translation.logo') <span
                        class="text-danger">*</span></label>
                    </div><!-- end card header -->
    
                    <div class="card-body">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img src="@if ($row->my_vendor->logo != '') {{ URL::asset($row->my_vendor->logo) }}@else{{ URL::asset('assets/images/users/avatar-1.jpg') }} @endif"
                                class="rounded-circle avatar-xl img-thumbnail store-profile-image" alt="user-profile-image" style="width: 244px;height: 202px;">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input-store" name="logo" style="display:none;" type="file" class="profile-img-file-input-store" onchange="showImage('profile-img-file-input-store','store-profile-image')">
                                <label for="profile-img-file-input-store" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
    
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">@lang('translation.broc')</h4>
                    </div><!-- end card header -->
    
                    <div class="card-body">
                        <p class="text-muted"></p>
                        <input type="file" id="broc" class="filepond filepond-input" name="broc"
                            data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">@lang('translation.cr')</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <label for="username" class="form-label">@lang('translation.crd') <span
                    class="text-danger">*</span></label>
                    <input type="date" class="form-control flatpickr-input active" name="crd" data-provider="flatpickr" value="{{ old('crd',\Carbon\Carbon::parse($row->my_vendor->crd)->toDateString()) }}" data-date-format="d.m.y" disabled >
                    @error('crd')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.please_enter_crd')
                    </div>
                    <p class="text-muted"></p>
                    <input type="file" id="cr" class="filepond filepond-input" name="cr"
                        data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">@lang('translation.tax_certificate')</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <label for="username" class="form-label">@lang('translation.tax_num') <span
                    class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('tax_num') is-invalid @enderror"
                        name="tax_num" value="{{ old('tax_num',$row->my_vendor->tax_num) }}" id="tax_num"
                        placeholder="@lang('translation.tax_num_placeholder')" required disabled>
                    @error('tax_num')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.please_enter_tax_num')
                    </div>
                    <p class="text-muted"></p>
                    <input type="file" id="tax_certificate" class="filepond filepond-input" name="tax_certificate"
                        data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        
        {{--<div class="col-lg-12">
            <div class="hstack gap-2 justify-content-end">
                <button type="submit" class="btn btn-primary">@lang('translation.update')</button>
                <button type="button" class="btn btn-soft-secondary">@lang('translation.cancel')</button>
            </div>
        </div>--}}
        <!--end col-->
    </div>
    <!--end row-->
</form>