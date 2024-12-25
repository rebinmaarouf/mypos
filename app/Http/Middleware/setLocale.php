<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class setLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $locale = $request->cookie('app_locale', config('app.locale'));
        // App::setlocale($locale);
        // return $next($request);
        $locale = $request->segment(1); // 'ar' or 'en'
        if (in_array($locale, ['ar', 'en'])) {
            App::setLocale($locale);
            session(['locale' => $locale]); // Store the locale in session for later use
        } else {
            App::setLocale(config('app.locale')); // Default fallback
        }

        return $next($request);
    }
}
