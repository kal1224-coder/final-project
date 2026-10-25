<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    // Trainee view
    public function userMaterials()
    {
        $materials = Material::latest()->get();
        return view('trainee.material', compact('materials'));
    }

    // Admin: list
    public function index()
    {
        $materials = Material::latest()->get();
        return view('admin.materials', compact('materials'));
    }

    // Admin: upload PDF
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file'  => 'required|file|mimes:pdf|max:20480',
            'description' => 'nullable|string',
        ]);

        $path = $request->file('file')->store('materials', 'public');

        Material::create([
            'title'       => $request->title,
            'type'        => 'pdf',
            'file_path'   => $path,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'PDF በተሳካ ሁኔታ ተጭኗል።');
    }

    // Admin: update
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file'  => 'nullable|file|mimes:pdf|max:20480',
            'description' => 'nullable|string',
        ]);

        $material = Material::findOrFail($id);
        $material->title       = $request->title;
        $material->description = $request->description;

        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::disk('public')->exists($material->file_path)) {
                Storage::disk('public')->delete($material->file_path);
            }
            $material->file_path = $request->file('file')->store('materials', 'public');
        }

        $material->save();
        return redirect()->back()->with('success', 'ቁሳቁሱ ተስተካክሏል።');
    }

    // Admin: delete
    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        if (Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();
        return redirect()->back()->with('success', 'ቁሳቁሱ ተሰርዟል።');
    }
}
