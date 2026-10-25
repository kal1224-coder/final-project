@extends('layouts.admin')
@section('page-title', 'Adverts')

@section('content')

{{-- Add Form --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h2 class="text-lg font-bold text-slate-900 mb-4">Add New Advert</h2>
    <form action="{{ route('admin.adverts.store') }}" method="POST" enctype="multipart/form-data"
          class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
            <input type="text" name="title" required
                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Messages</label>
            <input type="text" name="note" required
                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Image</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm">
        </div>
        <div class="md:col-span-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition">
                <i class="fas fa-plus mr-2"></i> Add
            </button>
        </div>
    </form>
</div>

{{-- Adverts List --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    @forelse($adverts as $advert)
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($advert->image)
        <img src="{{ asset('storage/' . $advert->image) }}" class="w-full h-40 object-cover">
        @else
        <div class="w-full h-40 bg-slate-100 flex items-center justify-center text-slate-400">
            <i class="fas fa-image text-4xl"></i>
        </div>
        @endif
        <div class="p-4">
            <h3 class="font-bold text-slate-800">{{ $advert->title }}</h3>
            <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ $advert->note }}</p>
            <button onclick="openAdvertModal('{{ addslashes($advert->title) }}', '{{ addslashes($advert->note) }}', '{{ $advert->image ? asset('storage/' . $advert->image) : '' }}')"
                    class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-700 transition">
                More <i class="fas fa-arrow-right text-[10px]"></i>
            </button>
            <div class="flex gap-2 mt-3">
                {{-- Edit button --}}
                <button onclick="openAdvertEdit({{ $advert->id }}, '{{ addslashes($advert->title) }}', '{{ addslashes($advert->note) }}')"
                        class="flex-1 bg-amber-50 hover:bg-amber-100 text-amber-600 py-2 rounded-xl text-sm font-semibold transition">
                    <i class="fas fa-edit mr-1"></i> Edit
                </button>
                {{-- Delete button --}}
                <form action="{{ route('admin.adverts.destroy', $advert->id) }}" method="POST"
                      class="flex-1" onsubmit="return confirm('Are you sure you want to delete this advert?')">
                    @csrf @method('DELETE')
                    <button class="w-full bg-red-50 hover:bg-red-100 text-red-600 py-2 rounded-xl text-sm font-semibold transition">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="md:col-span-3 text-center text-slate-400 py-12">No adverts found.</div>
    @endforelse
</div>

{{-- Edit Modal --}}
<div id="advertEditModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-bold text-slate-900 mb-4">
            <i class="fas fa-edit text-amber-500 mr-2"></i>Edit Advert
        </h3>
        <form id="advertEditForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                <input type="text" name="title" id="editAdvertTitle" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Message</label>
                <textarea name="note" id="editAdvertNote" required rows="3"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">New Image (optional)</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-sm font-semibold transition">
                    Save Changes
                </button>
                <button type="button" onclick="closeAdvertEdit()"
                        class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-2.5 rounded-xl text-sm font-semibold transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAdvertEdit(id, title, note) {
    document.getElementById('advertEditForm').action = '/admin/adverts/' + id;
    document.getElementById('editAdvertTitle').value = title;
    document.getElementById('editAdvertNote').value = note;
    document.getElementById('advertEditModal').style.display = 'flex';
}
function closeAdvertEdit() {
    document.getElementById('advertEditModal').style.display = 'none';
}
// Close on backdrop click
document.getElementById('advertEditModal').addEventListener('click', function(e) {
    if (e.target === this) closeAdvertEdit();
});
</script>

{{-- Detail Modal --}}
<div id="advertDetailModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:10000; align-items:center; justify-content:center; padding:16px;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden">
        <img id="detailImg" src="" class="w-full h-56 object-cover hidden">
        <div class="p-6">
            <h3 id="detailTitle" class="text-xl font-bold text-slate-800 mb-3"></h3>
            <p id="detailNote" class="text-sm text-slate-600 leading-relaxed whitespace-pre-line"></p>
            <button onclick="closeAdvertDetailModal()"
                    class="mt-5 w-full bg-slate-100 hover:bg-slate-200 text-slate-700 py-2.5 rounded-xl text-sm font-semibold transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function openAdvertModal(title, note, img) {
    document.getElementById('detailTitle').textContent = title;
    document.getElementById('detailNote').textContent = note;
    var imgEl = document.getElementById('detailImg');
    if (img) { imgEl.src = img; imgEl.classList.remove('hidden'); }
    else { imgEl.classList.add('hidden'); }
    document.getElementById('advertDetailModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeAdvertDetailModal() {
    document.getElementById('advertDetailModal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('advertDetailModal').addEventListener('click', function(e) {
    if (e.target === this) closeAdvertDetailModal();
});
</script>

@endsection
