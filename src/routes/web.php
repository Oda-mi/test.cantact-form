<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

use Laravel\Fortify\Http\Controllers\RegisteredUserController;


// ---------------------------
// トップページ
// ---------------------------

//お問い合わせフォーム入力画面の表示
Route::get('/', [ContactController::class, 'index']);

//フォーム入力画面から確認画面へ渡す
Route::post('/confirm', [ContactController::class, 'confirm']);

//フォームの入力をDBへ保存する
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

//確認画面からのサンクスページ表示
Route::get('/thanks', [ContactController::class, 'thanks']);



// ---------------------------
// Adminページ
// ---------------------------

//管理画面の表示
Route::get('/admin', [AdminController::class, 'index']);

//DBの削除
Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy']);

//エクスポート
Route::post('/admin/export', [AdminController::class, 'export']);



// ---------------------------
// registerページ
// ---------------------------

//登録画面の表示
Route::get('/register', [RegisterController::class, 'registerForm']);

//登録フォームのデータをDBへ保存してログインページにリダイレクト
Route::post('/register', [RegisterController::class, 'register']);



// ---------------------------
// loginページ
// ---------------------------

//ログイン画面の表示
Route::get('/login', [LoginController::class, 'loginForm']);

//ログイン処理
Route::post('/login', [LoginController::class, 'login']);





