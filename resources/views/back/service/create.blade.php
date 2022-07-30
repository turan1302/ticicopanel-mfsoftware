@extends('back.layout.master')

@section('content')
<admin-service-create-component geriye_don="{{ route('back.service.create') }}"></admin-service-create-component>
@endsection
