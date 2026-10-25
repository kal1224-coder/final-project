@extends('layouts.admin')
@section('page-title', 'Materials')

@section('content')

{{-- Upload Form --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h2 class="text-lg font-bold text-slate-900 mb-4">Upload PDF</h2>
    <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data"
          class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
            <input type="text" name="title" required
                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
            <input type="text" name="description"
                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">PDF file</label>
            <input type="file" name="file" accept=".pdf" required
                   class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm">
        </div>
        <div class="md:col-span-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition">
                <i class="fas fa-upload mr-2"></i> Upload
            </button>
        </div>
    </form>
</div>

{{-- Materials List --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100">
        <h2 class="text-lg font-bold text-slate-900">All Materials</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs border-b border-slate-100">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Descriptin</th>
                    <th class="px-6 py-3">File</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($materials as $i => $material)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-slate-400">{{ $i + 1 }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $material->title }}</td>
                    <td class="px-6 py-4 text-slate-500 text-xs">{{ $material->description ?? '—' }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                           class="inline-flex items-center gap-1 text-red-600 hover:underline text-sm">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                    </td>
                    <td class="px-6 py-4 text-xs text-slate-400">{{ $material->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2 items-center">
                            {{-- Edit Modal Trigger --}}
                            <button onclick="openEdit({{ $material->id }}, '{{ addslashes($material->title) }}', '{{ addslashes($material->description ?? '') }}')"
                                    class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            {{-- Delete --}}
                            <form action="{{ route('admin.materials.destroy', $material->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this PDF?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                    <i class="fas fa-trash"></i> DELETE
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">No materials uploaded yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Material</h3>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                    <input type="text" name="title" id="editTitle" required
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <input type="text" name="description" id="editDesc"
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">New PDF</label>
                    <input type="file" name="file" accept=".pdf"
                           class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm">
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-sm font-semibold transition">
                    Save
                </button>
                <button type="button" onclick="closeEdit()"
                        class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-2.5 rounded-xl text-sm font-semibold transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(id, title, desc) {
    document.getElementById('editForm').action = '/admin/materials/' + id;
    document.getElementById('editTitle').value = title;
    document.getElementById('editDesc').value = desc;
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}
function closeEdit() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}
</script>

@endsection
