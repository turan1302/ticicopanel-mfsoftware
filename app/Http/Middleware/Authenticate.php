<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
//    protected function redirectTo($request)
//    {
//        if (! $request->expectsJson()) {
//            return route('back.login');
//        }
//    }

    // GIRIS KISMI AYARLANAMSI GERCEKLESTIRELIM
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->guard('yonetim')->check()) {
            return redirect()->route('back.login');
        }
        return $next($request);
    }
}
