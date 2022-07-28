@extends('back.layout.master')

@section('css')
    <link href="{{ asset('back') }}/plugins/datatables/datatables.min.css" rel="stylesheet">
@endsection

@section('content')
    <div id="app">
        <admin-language-list-component></admin-language-list-component>
    </div>
@endsection

@section('js')
    <script src="{{ asset('back') }}/plugins/datatables/datatables.min.js"></script>
    <script src="{{ asset('back') }}/js/pages/datatables.js"></script>
@endsection
