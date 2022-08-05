@extends('back.layout.master')

@section('content')
    <admin-yetkiler-edit-component geriye_don="{{ route('back.yetkiler.index') }}" yt_id="{{ $item->yt_id }}"></admin-yetkiler-edit-component>
@endsection
