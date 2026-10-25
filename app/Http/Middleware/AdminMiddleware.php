<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // If a regular user tries to access admin pages, send them to trainee dashboard
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('trainee.dashboard')
                ->with('error', 'Admin page access is not allowed.');
        }

        return $next($request);
    }
}
