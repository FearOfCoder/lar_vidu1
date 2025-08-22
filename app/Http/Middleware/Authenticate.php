<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            // chưa đăng nhập => chuyển về trang login
            return redirect('/login');
        }
        return $next($request);
    }
}
