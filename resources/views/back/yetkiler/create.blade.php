@extends('back.layout.master')

@section('content')
    <admin-yetkiler-create-component geriye_don="{{ route('back.yetkiler.index') }}"></admin-yetkiler-create-component>
@endsection
