<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AdvertController extends Controller
{
    public function index()
    {
        $adverts = Announcement::latest()->get();
        return view('admin.adverts', compact('adverts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'note'  => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $path = $request->hasFile('image')
            ? $request->file('image')->store('adverts', 'public')
            : null;

        Announcement::create([
            'title' => $request->title,
            'note'  => $request->note,
            'image' => $path,
        ]);

        return redirect()->back()->with('success', 'ማስታወቂያ ተጨምሯል።');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'note'  => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $advert = Announcement::findOrFail($id);
        $advert->title = $request->title;
        $advert->note  = $request->note;

        if ($request->hasFile('image')) {
            if ($advert->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($advert->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($advert->image);
            }
            $advert->image = $request->file('image')->store('adverts', 'public');
        }

        $advert->save();
        return redirect()->back()->with('success', 'ማስታወቂያ ተስተካክሏል።');
    }

    public function destroy($id)
    {
        Announcement::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'ማስታወቂያ ተሰርዟል።');
    }
}
