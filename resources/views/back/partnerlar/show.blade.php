@extends('back.layout.master')

@section('content')
    <admin-partner-show-component
        partner_id="{{ $item->part_id }}"
        geriye_don="{{ route('back.partnerlar.index') }}"></admin-partner-show-component>
@endsection

@section('js')
    {{-- TINYMCE AYARLAMASI --}}
    <script src="{{ asset('back') }}/tinymce/tinymce.js"></script>

    <script>
        $(document).ready(function() {
            tinymce.init({
                readonly : true,
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
