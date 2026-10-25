<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TraineeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // If an admin tries to access trainee pages, send them to admin dashboard
        if (Auth::user()->usertype === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Trainee page access is not allowed for admins.');
        }

        return $next($request);
    }
}
