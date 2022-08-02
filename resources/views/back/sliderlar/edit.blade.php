@extends('back.layout.master')

@section('content')
    <admin-slider-edit-component
        slider_id="{{ $item->sld_id }}"
        geriye_don="{{ route('back.sliderlar.index') }}"></admin-slider-edit-component>
@endsection
