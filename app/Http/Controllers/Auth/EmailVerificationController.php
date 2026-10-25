<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
    // Show the verification code input page
    public function show()
    {
        if (Auth::user()->is_verified) {
            return redirect()->route('trainee.dashboard');
        }
        return view('auth.verify-code');
    }

    // Verify the submitted code
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:4',
        ]);

        $user = Auth::user();

        if ($user->verification_code !== $request->code) {
            return back()->withErrors(['code' => 'Invalid verification code. Please try again.']);
        }

        $user->update([
            'is_verified'       => true,
            'verification_code' => null,
        ]);

        return redirect()->route('trainee.dashboard')->with('success', 'Email verified successfully!');
    }

    // Resend the code
    public function resend()
    {
        $user = Auth::user();
        $code = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        $user->update(['verification_code' => $code]);

        Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name));

        return back()->with('success', 'A new verification code has been sent to your email.');
    }
}
