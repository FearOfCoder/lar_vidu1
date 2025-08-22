<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            // đã đăng nhập rồi thì không cho vào trang login/register nữa
            return redirect('/');
        }
        return $next($request);
    }
}
