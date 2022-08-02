@extends('back.layout.master')

@section('content')
    <admin-slider-edit-component
        slider_id="{{ $item->sld_id }}"
        geriye_don="{{ route('back.language.index') }}"></admin-slider-edit-component>
@endsection
