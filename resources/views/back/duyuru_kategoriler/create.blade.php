@extends('back.layout.master')

@section('content')
    <admin-duyuru-kategori-create-component geriye_don="{{ route('back.duyuru_kategoriler.index') }}"></admin-duyuru-kategori-create-component>
@endsection
