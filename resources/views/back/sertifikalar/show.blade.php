@extends('back.layout.master')

@section('content')
    <admin-sertifikalar-show-component geriye_don="{{ route('back.sertifikalar.index') }}" sr_id="{{ $item->sr_id }}"></admin-sertifikalar-show-component>
@endsection
