<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Cache\RateLimiting\Limit;

//use App\Actions\Fortify\ResetUserPassword;
//use App\Actions\Fortify\UpdateUserPassword;
//use App\Actions\Fortify\UpdateUserProfileInformation;
//use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {

        //ユーザー登録の処理
        Fortify::createUsersUsing(CreateNewUser::class);

        //登録画面のビュー
        Fortify::registerView(function () {
            return view('auth.register');
        });

        //ログイン画面のビュー
        Fortify::loginView(function () {
            return view('auth.login');
        });

        //ログインの処理
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
        });

        //ログインのタイムリミット
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

        //ログイン成功したら管理画面へ
        Fortify::redirects('login', '/admin');

        Fortify::redirects('register', '/admin');
    }
}
