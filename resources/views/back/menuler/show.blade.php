@extends('back.layout.master')

@section('content')
    <admin-menuler-show-component
        menuler="{{ $menuler }}"
        geriye_don="{{ route('back.menuler.index') }}"
        menu_id="{{ $item->menu_id }}"></admin-menuler-show-component>
@endsection

