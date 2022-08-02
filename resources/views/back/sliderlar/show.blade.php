@extends('back.layout.master')

@section('content')
    <admin-slider-show-component
        slider_id="{{ $item->sld_id }}"
        geriye_don="{{ route('back.sliderlar.index') }}"></admin-slider-show-component>
@endsection
