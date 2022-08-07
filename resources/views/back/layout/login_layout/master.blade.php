
<!DOCTYPE html>
<html lang="en">
<head>
    @include('back.layout.login_layout.head')
    @include('back.layout.login_layout.include_style')
    @yield('css')
</head>
<body>
<div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        @yield('content')
</div>

@include('back.layout.login_layout.include_script')
@yield('js')
@include('back.layout.login_layout.alert')
</body>
</html>
