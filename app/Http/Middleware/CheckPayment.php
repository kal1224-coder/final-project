<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPayment
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. ተጠቃሚው መግባቱን (Login ማድረጉን) ማረጋገጥ
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. ተጠቃሚው አድሚን ከሆነ ያለ ክፍያ ገደብ ማለፍ ይችላል
        if ($user->usertype === 'admin') {
            return $next($request);
        }

        // 3. ሰልጣኙ የጸደቀ (Approved) ክፍያ እንዳለው ማረጋገጥ
        $hasApprovedPayment = $user->payments()
            ->where('status', 'approved')
            ->exists();

        if ($hasApprovedPayment) {
            return $next($request); // ክፍያው ከጸደቀ ወደ ተጠየቀው ገጽ ያሳልፈዋል
        }

        // 4. ክፍያው ካልጸደቀ ወይም ገና ከሆነ ወደ Dashboard ይመልሰዋል
        return redirect()->route('dashboard')
            ->with('error', 'የመማሪያ ቁሳቁሶችን ለማየት አስቀድመው ክፍያ መፈጸም እና በአድሚን መጸደቅ አለበት።');
    }
}