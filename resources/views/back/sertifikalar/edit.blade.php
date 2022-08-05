@extends('back.layout.master')

@section('content')
    <admin-sertifikalar-edit-component geriye_don="{{ route('back.service.index') }}" service_id="{{ $item->service_id }}"></admin-sertifikalar-edit-component>
@endsection
