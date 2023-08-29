<div class="accordion accordion-flush" id="accordionFlushExample">
@if(count($row->new_images) > 0)
<div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingImages">
        <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#flush-collapseImages" aria-expanded="true" aria-controls="flush-collapseImages">
            @lang('admin.products.images')
        </button>
    </h2>
    <div id="flush-collapseImages" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
        data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
            @foreach($row->temp->images() as $temp_image)
            <img src="{{url($temp_image)}}" style="max-width: 270px;">
            @endforeach
        </div>
    </div>
</div>
@endif
@foreach(json_decode($row->temp->updated_data,true) ?? [] as $key=>$fieldUpdated)
    @if($key=='image')
        @if(! $fieldUpdated)
            @continue
        @endif
    @endif
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne{{$key}}">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapseOne{{$key}}" aria-expanded="true" aria-controls="flush-collapseOne">
                @lang('admin.'.$key)
            </button>
        </h2>
        <div id="flush-collapseOne{{$key}}" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                @lang('admin.products.field_changed') @lang('admin.'.$key)
                
                @if($key=='image')
                    @lang('admin.from')
                    <img src="{{url($row->image)}}" style="max-width: 270px;">
                    @lang('admin.to')
                    <img src="{{url($fieldUpdated)}}" style="max-width: 270px;">
                @else
                    @if($row->$key != $row->temp->$key)
                        @if($key=='quantity_type_id')
                            @lang('admin.from')
                                {{$row->quantity_type?->name}}
                            @lang('admin.to')
                                {{$row->temp->quantity_type?->name}}
                        @elseif($key=='category_id')
                            @lang('admin.from')
                                {{$row->category?->name}}
                            @lang('admin.to')
                                {{$row->temp->category?->name}}
                        @elseif($key=='sub_category_id')
                            @lang('admin.from')
                                {{$row->subCategory?->name}}
                            @lang('admin.to')
                                {{$row->temp->subCategory?->name}}
                        @elseif($key=='final_category_id')
                            @lang('admin.from')
                                {{$row->finalSubCategory?->name}}
                            @lang('admin.to')
                                {{$row->temp->finalSubCategory?->name}}
                        @elseif($key=='type_id')
                            @lang('admin.from')
                                {{$row->type?->name}}
                            @lang('admin.to')
                                {{$row->temp->type?->name}}
                        @elseif($key == "price")
                            {{ number_format(json_decode($row->temp?->updated_data,true)["price"] / 100, 2) }} @lang("translation.sar")
                        @elseif($key == "price_before_offer")
                            {{ number_format(json_decode($row->temp?->updated_data,true)["price_before_offer"] / 100, 2) }} @lang("translation.sar")
                        @else
                        @lang('admin.from')
                            {{$row->$key}}
                        @lang('admin.to')
                            {{$fieldUpdated}}
                        @endif
                    @endif
                    
                    @foreach(Config::get('app.locales') as $locale)
                        <!-- translated name -->
                        @if($key=='name_'.$locale && $row->getTranslation('name',$locale) != $row->temp->getTranslation('name',$locale))
                            @lang('admin.from')
                            {{$row->getTranslation('name',$locale)}}
                            @lang('admin.to')
                            {{$row->temp->getTranslation('name',$locale)}}
                        @endif
                         <!-- translated desc -->
                        @if($key=='desc_'.$locale && $row->getTranslation('desc',$locale) != $row->temp->getTranslation('desc',$locale))
                            @lang('admin.from')
                            {!!$row->getTranslation('desc',$locale)!!}
                            @lang('admin.to')
                            {!!$row->temp->getTranslation('desc',$locale)!!}
                        @endif
                    @endforeach
                    
                @endif
            </div>
        </div>
    </div>
@endforeach

</div>