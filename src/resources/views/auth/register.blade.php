
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection


@section('content')

<header class="header">
        <div class="header_inner">
            <a href="/" class="header_logo">
                FashionablyLate
            </a>
            <a href="/login" class="header_login">login</a>
        </div>
</header>

<div class="auth__content">
    <div class="auth__heading">
        <h2>Register</h2>
    </div>
    <form action="/register" method="post" class="form" novalidate>
        @csrf
        <div class="form__group">
            <label class="form__group-label" for="name">名前</label>
            <div class="form__group-input">
                <input type="text" name="name" id="name" placeholder="例:山田 太郎" value="{{ old('name') }}">
            </div>
            <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
        </div>
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
                <input type="password" name="password" id="password" placeholder="例:coachtech1106">
            </div>
            <div class="form__error">
                @error('password')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">登録</button>
        </div>
    </form>
</div>
@endsection