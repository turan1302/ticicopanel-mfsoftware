@extends('back.layout.master')

@section('content')
    <admin-verilen-yetkiler-edit-component
        yetkiler="{{ $yetkiler }}"
        geriye_don="{{ route('back.yetkiler.index') }}"
        yt_id="{{ $item->yt_id }}"></admin-verilen-yetkiler-edit-component>
@endsection
