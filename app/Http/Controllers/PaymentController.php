<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Announcement;
use App\Models\Price;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        $payment       = Auth::user()->payments()->latest()->first();
        // Get the first active price from the prices table
        $activePrice   = Price::where('is_active', true)->latest()->first();
        $trainingPrice = $activePrice ? $activePrice->amount : 500;
        $pricingLabel  = $activePrice ? $activePrice->label : 'Training Fee';
        return view('trainee.dashboard', compact('announcements', 'payment', 'trainingPrice', 'pricingLabel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('screenshot')->store('payments', 'public');

        Payment::create([
            'user_id'    => Auth::id(),
            'full_name'  => $request->full_name,
            'phone'      => $request->phone,
            'screenshot' => $path,
            'status'     => 'pending',
        ]);

        return redirect()->route('trainee.dashboard')
            ->with('success', 'ምዝገባዎ ተልኳል። አድሚኑ እስኪያጸድቀው ድረስ ይጠብቁ።');
    }
}
