@extends('back.layout.master')

@section('content')
    <admin-ekip-create-component geriye_don="{{ route('back.ekip.index') }}"></admin-ekip-create-component>
@endsection
