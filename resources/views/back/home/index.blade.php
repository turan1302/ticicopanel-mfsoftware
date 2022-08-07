@extends('back.layout.master')

@section('content')
        <admin-home-component
        sertifika_sayi="{{ $sertifikalar }}"
        servis_sayi="{{ $servisler }}"
        mesaj_sayi="{{ $mesajlar }}"
        son_10_mesaj="{{ $son_10_mesaj }}"
        ></admin-home-component>
@endsection

