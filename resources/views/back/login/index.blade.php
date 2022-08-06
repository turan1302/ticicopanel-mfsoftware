@extends('back.layout.login_layout.master')

@section('content')
<div class="app-auth-background"></div>
<div class="app-auth-container">
    <div class="logo">
        <a href="{{ route('back.home.index') }}">Neptune</a>
    </div>
    <p class="auth-description">
        Panele giriş yapmak için bilgilerinizi giriniz
    </p>

    <form action="{{ route('back.do_login') }}" method="POST">
        @csrf
        <div class="auth-credentials m-b-xxl">
            <label for="signInEmail" class="form-label">E-Mail Adresiniz</label>
            <input type="text" name="email" value="{{ old('email') ?? '' }}" class="form-control" placeholder="E-Mail Adresiniz">
            @error('email')
                <small style="color: red;">{{ $message }}</small>
            @enderror

            <br>

            <label for="signInPassword" class="form-label">Şifreniz</label>
            <input type="password" name="password" class="form-control"  placeholder="Şifreniz">
            @error('password')
            <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div class="auth-submit">
            <button type="submit" class="btn btn-primary">Giriş Yap</button>
        </div>
    </form>
    <div class="divider"></div>
</div>
@endsection
