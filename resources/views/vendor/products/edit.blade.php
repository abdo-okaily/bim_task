@extends('vendor.layouts.master')
@section('title')
    @lang('translation.create-product')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        #form-loader {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: black;
            z-index: 9999;
            opacity: .5;
            display: flex;
            justify-content: center;
            align-items: center
        }
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Ecommerce
        @endslot
        @slot('title')
            @lang('translation.edit_product')
        @endslot
    @endcomponent
    {{ Form::model($row,['route' => ['vendor.products.update',$row->id],'id'=>'createproduct-form','autocomplete'=>'off','class'=>'needs-validation','method'=>'PATCH','enctype'=>'multipart/form-data']) }}
        
        @include('vendor.products.form')

    {!! Form::close() !!}

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>

    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script src="{{ URL::asset('assets/js/pages/vendor-product-create.init.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        //dropzone is defined before at assets/js/pages/ecommerce-product-create.init.js
        @foreach($row->images as $image)
            productImages_ids.push('{{$image->id}}')
            $('#images-hidden').val(productImages_ids.toString())
            dropzone.displayExistingFile({ name: "Filename", size: 12345 , id: "{{$image->id}}"}, '/{{$image->image}}');
        @endforeach
    </script>
@endsection
