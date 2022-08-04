@extends('back.layout.master')

@section('content')
    <admin-menuler-create-component geriye_don="{{ route('back.menuler.index') }}"></admin-menuler-create-component>
@endsection

