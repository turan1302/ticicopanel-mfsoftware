@extends('back.layout.master')

@section('css')
<link href="{{ asset('back') }}/plugins/datatables/datatables.min.css" rel="stylesheet">
<link href="{{ asset('back') }}/css/toggle.css" rel="stylesheet">
@endsection

@section('content')
<admin-aboneler-list-component yeni_ekle="{{ route('back.menuler.create') }}"></admin-aboneler-list-component>
@endsection

@section('js')
<script src="{{ asset('back') }}/plugins/datatables/datatables.min.js"></script>
<script src="{{ asset('back') }}/js/pages/datatables.js"></script>
@endsection
