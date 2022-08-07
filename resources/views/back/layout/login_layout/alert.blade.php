@if(session('type'))
    <script>
        iziToast.{{ session('type') }}({
            title: '{{ session('title') }}',
            message: '{{ session('text') }}',
            position : 'topCenter'
        });
    </script>
@endif
