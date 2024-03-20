<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next): Response
    {

        // Мидлвара чекает куку на наличие лара-сессии, если сессия авторизована, пускает как админа
        if (Auth::check()) {
            return $next($request);
        } else {
            // Если нет, редиректит на паблик
            return redirect('/create');
        }
    }
}
