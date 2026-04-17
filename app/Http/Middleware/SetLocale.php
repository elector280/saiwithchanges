<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale')
            ?? (Auth::user()->locale ?? null)
            ?? config('app.locale', 'en');

        // ঐচ্ছিক: short codes normalize
        $map = ['en' => 'en', 'es' => 'es'];
        $locale = $map[$locale] ?? $locale;

        App::setLocale($locale);
        setlocale(LC_TIME, $locale);

        return $next($request);
    }
}
