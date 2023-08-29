@php
    $nationalDisplay = (isset($domesticZone) ? $domesticZone->type : old('type')) == \App\Enums\DomesticZone::NATIONAL_TYPE ? 'block' : 'none';
    $internationalDisplay = (isset($domesticZone) ? $domesticZone->type : old('type')) == \App\Enums\DomesticZone::INTERNATIONAL_TYPE ? 'block' : 'none';
@endphp

<div class="col-md-6">
    <label for="name" class="form-label">@lang('admin.delivery.domestic-zones.name-ar')</label>
    <input name="name_ar" class="form-control" value="{{ isset($domesticZone) ? $domesticZone->getTranslation('name', 'ar') : old('name_ar') }}">
    @error('name_ar')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="col-md-6">
    <label for="email" class="form-label">@lang('admin.delivery.domestic-zones.name-en')</label>
    <input name="name_en" class="form-control" value="{{ isset($domesticZone) ? $domesticZone->getTranslation('name', 'en') : old('name_en') }}">
    @error('name_en')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="col-md-6">
    <label for="type" class="form-label">@lang('admin.delivery.domestic-zones.delivery-type')</label>
    <select name="type" id="shipping_type" class="js-example-basic-single form-select">
        <option value='0'>@lang('admin.shipping_type_placeholder')</option>
        @foreach($shippingType as $type => $typeText)
            <option value='{{ $type }}'
                @selected((isset($domesticZone) ? $domesticZone->type : old('type')) == $type)
            > {{ $typeText }} </option>
        @endforeach
    </select>
    @error('type')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="col-md-6" style="display:{{ $internationalDisplay }}" id="countries_list">
    <label for="countries" class="form-label">@lang('admin.delivery.domestic-zones.countries')</label>
    <select name="countries[]" id="countries" class="form-select" dir="rtl" data-choices data-choices-removeItem multiple>
        @foreach($countries as $country)
            <option @selected(in_array($country->id, isset($selectedMeta) ? $selectedMeta : (old('countries') ?? [])))
                value='{{ $country->id }}'>{{ $country->name }}</option>
        @endforeach
    </select>
    @error('countries')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    @error('countries.*')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div style="display:{{ $nationalDisplay }}" class="col-md-6" id="cities_list">
    <label for="cities" class="js-example-basic-multiple">@lang('admin.delivery.domestic-zones.cities')</label>
    <select name="cities[]" id="cities" class="form-select" dir="rtl" data-choices data-choices-removeItem multiple>
        @foreach($cities as $city)
            <option @selected(in_array($city->id, isset($selectedMeta) ? $selectedMeta : (old('cities') ?? [])))
                value='{{ $city->id }}'>{{ $city->name }}</option>
        @endforeach
    </select>
    @error('cities')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    @error('cities.*')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="col-lg-6 national-extra-fields" style="display:{{ $nationalDisplay }}">
    <div class="mb-3">
        <label class="form-label" for="delivery_fees">@lang('admin.delivery.domestic-zones.delivery_fees') @lang('translation.sar')</label>
        <input type="text" name="delivery_fees" class="form-control"
            value="{{ isset($domesticZone) ? $domesticZone->delivery_fees : old("delivery_fees") }}"
            id="delivery_fees"
            placeholder="{{ trans('admin.delivery.domestic-zones.delivery_fees') }}  @lang('translation.sar')"
            step=".01">
        @error('delivery_fees')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="col-lg-6 national-extra-fields" style="display:{{ $nationalDisplay }}">
    <div class="mb-3">
        <label class="form-label" for="delivery_fees_covered_kilos">@lang('admin.delivery.domestic-zones.delivery_fees_covered_kilos')</label>
        <input type="text" 
            name="delivery_fees_covered_kilos" 
            class="form-control"
            value="{{ isset($domesticZone) ? $domesticZone->delivery_fees_covered_kilos : old("delivery_fees_covered_kilos") }}"
            id="delivery_fees_covered_kilos"
            placeholder="{{ trans('admin.delivery.domestic-zones.delivery_fees_covered_kilos') }}" 
            >
        @error('delivery_fees_covered_kilos')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="col-lg-6 national-extra-fields" style="display:{{ $nationalDisplay }}">
    <div class="mb-3">
        <label class="form-label" for="additional_kilo_price">@lang('admin.delivery.domestic-zones.additional_kilo_price')  @lang('translation.sar')</label>
        <input type="text" 
            name="additional_kilo_price" 
            class="form-control"
            value="{{ isset($domesticZone) ? $domesticZone->additional_kilo_price : old("additional_kilo_price") }}"
            id="additional_kilo_price"
            placeholder="{{ trans('admin.delivery.domestic-zones.additional_kilo_price') }}  @lang('translation.sar')" 
            step=".01">
        @error('additional_kilo_price')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
