@extends('back.layout.master')

@section('content')
    <admin-ekip-edit-component
        ekip_id="{{ $item->ekp_id }}"
        geriye_don="{{ route('back.ekip.index') }}"></admin-ekip-edit-component>
@endsection
