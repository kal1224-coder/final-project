<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Material;
use App\Models\Announcement;
use App\Models\Price;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalTrainees'  => User::where('usertype', 'user')->count(),
            'pendingCount'   => Payment::where('status', 'pending')->count(),
            'approvedCount'  => Payment::where('status', 'approved')->count(),
            'materialsCount' => Material::count(),
            'trainingPrice'  => Price::where('is_active', true)->latest()->value('amount') ?? 500,
            'recentTrainees' => User::where('usertype', 'user')
                                    ->with('payments')
                                    ->latest()
                                    ->take(10)
                                    ->get(),
        ]);
    }

    public function trainees()
    {
        $trainees = User::where('usertype', 'user')->with('payments')->latest()->get();
        return view('admin.trainees', compact('trainees'));
    }

    public function payments()
    {
        $payments = Payment::with('user')->latest()->get();
        return view('admin.payments', compact('payments'));
    }

    public function approvePayment($id)
    {
        Payment::findOrFail($id)->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'ክፍያው ጸድቋል።');
    }

    public function rejectPayment($id)
    {
        Payment::findOrFail($id)->update(['status' => 'rejected']);
        return redirect()->back()->with('error', 'ክፍያው ውድቅ ተደርጓል።');
    }
}
