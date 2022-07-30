@extends('back.layout.master')

@section('content')
    <admin-language-edit-component
        dil_id="{{ $item->dil_id }}"
        geriye_don="{{ route('back.language.index') }}"></admin-language-edit-component>
@endsection
