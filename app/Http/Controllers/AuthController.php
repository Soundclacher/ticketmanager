<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
//    Форма для логина
    public function login() {
        return view('auth.login');
    }

    // Метод для формы, принимает логин и пароль, проверяет их, регенерит сессию
    public function auth(Request $request) {
        $login = $request->input('login');
        $pass = $request->input('password');

        Auth::attempt(['name' => $login, 'password' => $pass]);

        $request->session()->regenerate();

        return redirect()->intended('/tickets');
    }
}
