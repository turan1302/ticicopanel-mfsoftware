@extends('back.layout.master')

@section('content')
    <admin-language-create-component geriye_don="{{ route('back.language.index') }}"></admin-language-create-component>
@endsection
