<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {
        $prices = Price::latest()->get();
        return view('admin.prices', compact('prices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label'  => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        Price::create([
            'label'     => $request->label,
            'amount'    => $request->amount,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Price added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'label'  => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        Price::findOrFail($id)->update([
            'label'     => $request->label,
            'amount'    => $request->amount,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Price updated successfully.');
    }

    public function destroy($id)
    {
        Price::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Price deleted.');
    }
}
