@extends('back.layout.master')

@section('css')
<link href="{{ asset('back') }}/plugins/datatables/datatables.min.css" rel="stylesheet">
<link href="{{ asset('back') }}/css/toggle.css" rel="stylesheet">
@endsection

@section('content')
<admin-iletisim-mesajlari-list-component></admin-iletisim-mesajlari-list-component>
@endsection

@section('js')
<script src="{{ asset('back') }}/plugins/datatables/datatables.min.js"></script>
<script src="{{ asset('back') }}/js/pages/datatables.js"></script>
@endsection
