@extends('back.layout.master')

@section('css')
    <link href="{{ asset('back') }}/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <admin-duyuru-create-component
        geriye_don="{{ route('back.duyurular.index') }}"
        duyuru_kategoriler="{{ $duyuru_kategoriler }}"
    ></admin-duyuru-create-component>
@endsection

@section('js')
    {{-- TINYMCE AYARLAMASI --}}
    <script src="{{ asset('back') }}/tinymce/tinymce.js"></script>

    {{-- SELECT 2 AYARLAMASI --}}
    <script src="{{ asset('back') }}/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.varsayilan').select2();  // VARSAYILAN OLARAK HANGI KATEGORI OLACAK ONUN AYARLANAMSI
            $('.kategori').select2();  // HANGI KATEGIORILERDE GORUNECEK ONUN AYARLANAMSI
        });
    </script>


    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: "textarea.editor",
                width: "100%",
                height: 300,
                plugins: ["advlist codesample link image charmap print preview hr anchor pagebreak",
                    "searchreplace visualblocks visualchars code insertdatetime media nonbreaking",
                    "save table directionality emoticons template paste wordcount"],
                language: "tr_TR",
                toolbar: "insertfile code | undo redo | styleselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | " +
                    " link unlink anchor | image | codesample fullpage"
            })

        })
    </script>
@endsection
