@extends('layouts.admin')
@section('page-title', 'Training Prices')

@section('content')

{{-- Add Price Form --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <div class="flex items-center gap-2 mb-5">
        <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
            <i class="fas fa-tag text-amber-500 text-sm"></i>
        </div>
        <h2 class="text-base font-bold text-slate-800">Add New Price</h2>
    </div>

    <form action="{{ route('admin.prices.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Training Name / Label</label>
                <input type="text" name="label" placeholder="e.g. Basic Training" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Amount (ETB)</label>
                <input type="number" name="amount" placeholder="e.g. 500" min="0" step="0.01" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <div class="flex items-center gap-4">
                <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                    <input type="checkbox" name="is_active" checked
                           class="w-4 h-4 rounded border-slate-300 text-amber-500 focus:ring-amber-400">
                    Show on registration
                </label>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-amber-100 transition">
                    <i class="fas fa-plus text-xs"></i> Add Price
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Prices Table --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-slate-800 rounded-lg flex items-center justify-center">
                <i class="fas fa-list text-white text-xs"></i>
            </div>
            <div>
                <h2 class="text-sm font-bold text-slate-800">All Training Prices</h2>
                <p class="text-xs text-slate-400">Active prices appear on the trainee registration form</p>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50/70 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Label</th>
                    <th class="px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Amount (ETB)</th>
                    <th class="px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($prices as $i => $price)
                <tr class="hover:bg-amber-50/30 transition group">
                    <td class="px-6 py-4 text-slate-300 text-xs font-mono">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $price->label }}</td>
                    <td class="px-6 py-4">
                        <span class="text-lg font-extrabold text-amber-600">ETB {{ number_format($price->amount) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($price->is_active)
                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-xs px-3 py-1.5 rounded-full font-semibold border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-slate-50 text-slate-500 text-xs px-3 py-1.5 rounded-full font-semibold border border-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 inline-block"></span> Hidden
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button onclick="openEditPrice({{ $price->id }}, '{{ addslashes($price->label) }}', {{ $price->amount }}, {{ $price->is_active ? 'true' : 'false' }})"
                                    class="inline-flex items-center gap-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                <i class="fas fa-pen text-[10px]"></i> Edit
                            </button>
                            <form action="{{ route('admin.prices.destroy', $price->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this price?')">
                                @csrf @method('DELETE')
                                <button class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                    <i class="fas fa-trash text-[10px]"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fas fa-tag text-3xl text-slate-200"></i>
                            <p class="text-slate-400 text-sm">No prices set yet</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Edit Modal --}}
<div id="priceEditModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:9999; align-items:center; justify-content:center;">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4">
        <h3 class="text-base font-bold text-slate-900 mb-5">
            <i class="fas fa-pen text-blue-500 mr-2"></i> Edit Price
        </h3>
        <form id="priceEditForm" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Label</label>
                <input type="text" name="label" id="editPriceLabel" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Amount (ETB)</label>
                <input type="number" name="amount" id="editPriceAmount" min="0" step="0.01" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                    <input type="checkbox" name="is_active" id="editPriceActive"
                           class="w-4 h-4 rounded border-slate-300 text-blue-500 focus:ring-blue-400">
                    Show on registration form
                </label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-sm font-semibold transition">
                    Save Changes
                </button>
                <button type="button" onclick="closePriceEdit()"
                        class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-2.5 rounded-xl text-sm font-semibold transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditPrice(id, label, amount, isActive) {
    document.getElementById('priceEditForm').action = '/admin/prices/' + id;
    document.getElementById('editPriceLabel').value = label;
    document.getElementById('editPriceAmount').value = amount;
    document.getElementById('editPriceActive').checked = isActive;
    document.getElementById('priceEditModal').style.display = 'flex';
}
function closePriceEdit() {
    document.getElementById('priceEditModal').style.display = 'none';
}
document.getElementById('priceEditModal').addEventListener('click', function(e) {
    if (e.target === this) closePriceEdit();
});
</script>

@endsection
