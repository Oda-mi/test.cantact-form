<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

//ログイン処理に使う
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{

    //ログイン画面の表示
    public function loginForm()
    {
        return view('auth.login');
    }


    //ログイン処理
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // ログイン成功したらセッション再生成して管理画面へリダイレクト
            $request->session()->regenerate();
            return redirect('/admin');
        }

        // ログイン失敗時
        return back()->withErrors([
            'email' => 'メールアドレスかパスワードが間違っています',
        ])->onlyInput('email');
    }
}
