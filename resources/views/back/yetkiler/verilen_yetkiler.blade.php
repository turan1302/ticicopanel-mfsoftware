@extends('back.layout.master')

@section('css')
    <link href="{{ asset('back') }}/plugins/datatables/datatables.min.css" rel="stylesheet">
    <link href="{{ asset('back') }}/css/toggle.css" rel="stylesheet">
@endsection

@section('content')
    <admin-verilen-yetkiler-edit-component
        yetkiler="{{ $yetkiler }}"
        geriye_don="{{ route('back.yetkiler.index') }}"
        yt_id="{{ $item->yt_id }}"></admin-verilen-yetkiler-edit-component>
@endsection

@section('js')
    <script src="{{ asset('back') }}/plugins/datatables/datatables.min.js"></script>
    <script src="{{ asset('back') }}/js/pages/datatables.js"></script>
@endsection
