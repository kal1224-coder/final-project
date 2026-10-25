@extends('layouts.admin')
@section('page-title', 'Payments')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100">
        <h2 class="text-lg font-bold text-slate-900">Payment Approvals</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs border-b border-slate-100">
                <tr>
                    <th class="px-6 py-3">Trainee</th>
                    <th class="px-6 py-3">Full Name</th>
                    <th class="px-6 py-3">Phone</th>
                    <th class="px-6 py-3">Transaction Code</th>
                    <th class="px-6 py-3">Screenshot</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payments as $payment)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $payment->user->name }}</p>
                        <p class="text-xs text-slate-400">{{ $payment->user->email }}</p>
                    </td>
                    <td class="px-6 py-4 text-slate-700">{{ $payment->full_name }}</td>
                    <td class="px-6 py-4 text-slate-700">{{ $payment->phone }}</td>
                    <td class="px-6 py-4 font-mono text-slate-700">{{ $payment->transaction_code }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ asset('storage/' . $payment->screenshot) }}" target="_blank"
                           class="inline-flex items-center gap-1 text-blue-600 hover:underline text-sm font-medium">
                            <i class="fas fa-image"></i> View
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        @if($payment->status === 'approved')
                            <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-bold">Approved</span>
                        @elseif($payment->status === 'rejected')
                            <span class="bg-red-100 text-red-800 text-xs px-2.5 py-1 rounded-full font-bold">Rejected</span>
                        @else
                            <span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-1 rounded-full font-bold">Pending</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($payment->status === 'pending')
                        <div class="flex gap-2">
                            <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST">
                                @csrf
                                <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                    Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                                @csrf
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                    Reject
                                </button>
                            </form>
                        </div>
                        @else
                            <span class="text-slate-400 text-xs italic">Done</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-slate-400">No payments submitted yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
