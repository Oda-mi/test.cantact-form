<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{

    //登録画面の表示
    public function registerForm()
    {
        return view('auth.register');
    }


    //ユーザー登録処理
    public function register(RegisterRequest $request)
    {
        User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect('/login');
    }
}
