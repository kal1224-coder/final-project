<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_verified && Auth::user()->usertype !== 'admin') {
            return redirect()->route('verify.code.show');
        }
        return $next($request);
    }
}
