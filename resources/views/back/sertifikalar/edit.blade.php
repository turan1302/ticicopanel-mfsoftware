@extends('back.layout.master')

@section('content')
    <admin-sertifikalar-edit-component geriye_don="{{ route('back.sertifikalar.index') }}" sr_id="{{ $item->sr_id }}"></admin-sertifikalar-edit-component>
@endsection
