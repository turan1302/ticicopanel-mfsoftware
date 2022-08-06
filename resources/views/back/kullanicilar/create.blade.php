@extends('back.layout.master')

@section('css')
    <link href="{{ asset('back') }}/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <admin-kullanicilar-create-component
        yetkiler="{{ $yetkiler }}"
        geriye_don="{{ route('back.kullanicilar.index') }}"></admin-kullanicilar-create-component>
@endsection

@section('js')
    {{-- SELECT 2 AYARLAMASI --}}
    <script src="{{ asset('back') }}/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.yetki').select2();
        });
    </script>
@endsection

