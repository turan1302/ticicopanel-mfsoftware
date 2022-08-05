@extends('back.layout.master')

@section('content')
    <admin-sertifikalar-create-component geriye_don="{{ route('back.sertifikalar.index') }}"></admin-sertifikalar-create-component>
@endsection
