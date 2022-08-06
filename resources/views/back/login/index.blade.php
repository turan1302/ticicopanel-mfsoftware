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

    <div class="auth-credentials m-b-xxl">
        <label for="signInEmail" class="form-label">E-Mail Adresiniz</label>
        <input type="email" class="form-control m-b-md" id="signInEmail" aria-describedby="signInEmail" placeholder="example@neptune.com">

        <label for="signInPassword" class="form-label">Şifreniz</label>
        <input type="password" class="form-control" id="signInPassword" aria-describedby="signInPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
    </div>

    <div class="auth-submit">
        <a href="#" class="btn btn-primary">Sign In</a>
        <a href="#" class="auth-forgot-password float-end">Forgot password?</a>
    </div>
    <div class="divider"></div>
</div>
@endsection
