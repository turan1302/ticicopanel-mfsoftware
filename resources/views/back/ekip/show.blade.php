@extends('back.layout.master')

@section('content')
    <admin-ekip-show-component
        ekip_id="{{ $item->ekp_id }}"
        geriye_don="{{ route('back.ekip.index') }}"></admin-ekip-show-component>
@endsection
