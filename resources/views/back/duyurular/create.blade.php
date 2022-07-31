@extends('back.layout.master')

@section('css')
    <link href="{{ asset('back') }}/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <admin-duyuru-create-component
        geriye_don="{{ route('back.duyurular.index') }}"
        duyuru_kategoriler="{{ $duyuru_kategoriler }}"
    ></admin-duyuru-create-component>
@endsection

@section('js')
    <script src="{{ asset('back') }}/js/select2.min.js"></script>
@endsection
