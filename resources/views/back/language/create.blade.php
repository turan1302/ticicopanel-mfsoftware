@extends('back.layout.master')

@section('content')
    <div id="app">
        <admin-language-create-component geriye_don="{{ route('back.language.index') }}"></admin-language-create-component>
    </div>
@endsection
