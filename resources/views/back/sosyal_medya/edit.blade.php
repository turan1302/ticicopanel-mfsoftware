@extends('back.layout.master')

@section('content')
    <admin-sosyal-medya-edit-component geriye_don="{{ route('back.sosyal_medya.index') }}" sosyal_medya_id="{{ $item->sm_id }}"></admin-sosyal-medya-edit-component>
@endsection
