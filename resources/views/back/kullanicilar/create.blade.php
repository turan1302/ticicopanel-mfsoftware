@extends('back.layout.master')

@section('content')
    <admin-kullanicilar-create-component geriye_don="{{ route('back.kullanicilar.index') }}"></admin-kullanicilar-create-component>
@endsection

