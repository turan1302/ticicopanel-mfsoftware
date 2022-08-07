<!DOCTYPE html>
<html lang="en">
<head>
    @include('back.layout.head')
    @include('back.layout.include_style')
    @yield('css')
</head>
<body>
<div class="app align-content-stretch d-flex flex-wrap">
    @include('back.layout.aside')

    <div class="app-container">
        @include('back.layout.header')
        <div id="app">
            @yield('content')
        </div>
    </div>
</div>
@include('back.layout.include_script')
@yield('js')

@include('back.layout.alert')
</body>
</html>
