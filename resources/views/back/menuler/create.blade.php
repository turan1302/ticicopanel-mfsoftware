@extends('back.layout.master')

@section('css')
    <link href="{{ asset('back') }}/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <admin-menuler-create-component
        menuler="{{ $menuler }}"
        geriye_don="{{ route('back.menuler.index') }}"></admin-menuler-create-component>
@endsection

@section('js')
    {{-- SELECT 2 AYARLAMASI --}}
    <script src="{{ asset('back') }}/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.menu_ust_id').select2();  // VARSAYILAN OLARAK HANGI KATEGORI OLACAK ONUN AYARLANAMSI
        });
    </script>
@endsection
