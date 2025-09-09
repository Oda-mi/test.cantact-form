@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection


@section('content')

<header class="header">
        <div class="header_inner">
            <a href="/" class="header_logo">
                FashionablyLate
            </a>
            <a href="/register" class="header_register">register</a>
        </div>
</header>

<div class="auth__content">
    <div class="auth__heading">
        <h2>Login</h2>
    </div>
    <form action="/login" method="post" class="form" novalidate>
        @csrf
        <div class="form__group">
            <label class="form__group-label" for="email">メールアドレス</label>
            <div class="form__group-input">
                <input type="email" name="email" id="email" placeholder="例:test@example.com" value="{{ old('email') }}">
            </div>
            <div class="form__error">
                @error('email')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__group">
            <label class="form__group-label" for="password">パスワード</label>
            <div class="form__group-input">
                <input type="password" name="password" id="password" placeholder="例:coachtech1234">
            </div>
            <div class="form__error">
                @error('password')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">ログイン</button>
        </div>
    </form>
</div>
@endsection
