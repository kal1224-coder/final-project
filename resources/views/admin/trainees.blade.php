@extends('layouts.admin')
@section('page-title', 'Trainees')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100">
        <h2 class="text-lg font-bold text-slate-900">All Trainees</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs border-b border-slate-100">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Phone</th>
                    <th class="px-6 py-3">Registered</th>
                    <th class="px-6 py-3">Payment Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($trainees as $i => $trainee)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-slate-400">{{ $i + 1 }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $trainee->name }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $trainee->email }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $trainee->payments->first()?->phone ?? '—' }}</td>
                    <td class="px-6 py-4 text-slate-400 text-xs">{{ $trainee->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        @php $p = $trainee->payments->first(); @endphp
                        @if($p?->status === 'approved')
                            <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-bold">Approved</span>
                        @elseif($p?->status === 'pending')
                            <span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-1 rounded-full font-bold">Pending</span>
                        @elseif($p?->status === 'rejected')
                            <span class="bg-red-100 text-red-800 text-xs px-2.5 py-1 rounded-full font-bold">Rejected</span>
                        @else
                            <span class="bg-slate-100 text-slate-500 text-xs px-2.5 py-1 rounded-full">No Payment</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">No trainees found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
