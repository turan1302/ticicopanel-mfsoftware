@extends('back.layout.master')

@section('content')
    <admin-duyuru-kategori-show-component dkat_id="{{ $item->dkat_id }}" geriye_don="{{ route('back.duyuru_kategoriler.index') }}"></admin-duyuru-kategori-show-component>
@endsection
