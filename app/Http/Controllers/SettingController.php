<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function updatePrice(Request $request)
    {
        $request->validate([
            'training_price' => 'required|numeric|min:0',
        ]);

        Setting::set('training_price', $request->training_price);

        return redirect()->back()->with('success', 'Training price updated successfully.');
    }
}
