@extends('back.layout.master')

@section('content')
    <admin-duyuru-create-component
        geriye_don="{{ route('back.duyurular.index') }}"
        duyuru_kategoriler="{{ $duyuru_kategoriler }}"
    ></admin-duyuru-create-component>
@endsection
