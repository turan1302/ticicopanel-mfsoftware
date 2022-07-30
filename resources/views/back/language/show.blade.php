@extends('back.layout.master')

@section('content')
    <admin-language-show-component
        dil_id="{{ $item->dil_id }}"
        geriye_don="{{ route('back.language.index') }}"></admin-language-show-component>
@endsection

