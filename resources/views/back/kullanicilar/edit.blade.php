@extends('back.layout.master')

@section('content')
    <admin-kullanicilar-edit-component
        user_id="{{ $item->id }}"
        geriye_don="{{ route('back.kullanicilar.index') }}"></admin-kullanicilar-edit-component>
@endsection
