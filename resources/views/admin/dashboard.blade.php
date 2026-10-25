@extends('layouts.admin')
@section('page-title', 'Dashboard')

@section('content')

{{-- ── Stat Cards ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

    <a href="{{ route('admin.trainees') }}"
       class="stat-card card-glow relative bg-gradient-to-br from-blue-500 to-blue-700 text-white p-6 rounded-2xl shadow-lg overflow-hidden group cursor-pointer">
        <div class="absolute -right-5 -top-5 w-24 h-24 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
        <div class="absolute right-2 -bottom-8 w-32 h-32 bg-white/5 rounded-full"></div>
        <p class="text-xs font-semibold uppercase tracking-widest text-blue-200 mb-1">All Trainees</p>
        <h3 class="text-4xl font-extrabold">{{ $totalTrainees }}</h3>
        <p class="text-xs text-blue-200 mt-2">Registered users</p>
        <i class="fas fa-users text-4xl text-white/20 absolute right-6 bottom-5 group-hover:text-white/40 transition-all duration-300"></i>
    </a>

    <a href="{{ route('admin.payments.index') }}"
       class="stat-card card-glow relative bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-6 rounded-2xl shadow-lg overflow-hidden group cursor-pointer">
        <div class="absolute -right-5 -top-5 w-24 h-24 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
        <div class="absolute right-2 -bottom-8 w-32 h-32 bg-white/5 rounded-full"></div>
        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-200 mb-1">Approved Payments</p>
        <h3 class="text-4xl font-extrabold">{{ $approvedCount }}</h3>
        <p class="text-xs text-emerald-200 mt-2">Access granted</p>
        <i class="fas fa-circle-check text-4xl text-white/20 absolute right-6 bottom-5 group-hover:text-white/40 transition-all duration-300"></i>
    </a>

    <a href="{{ route('admin.payments.index') }}"
       class="stat-card card-glow relative bg-gradient-to-br from-orange-400 to-amber-600 text-white p-6 rounded-2xl shadow-lg overflow-hidden group cursor-pointer">
        <div class="absolute -right-5 -top-5 w-24 h-24 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
        <div class="absolute right-2 -bottom-8 w-32 h-32 bg-white/5 rounded-full"></div>
        <p class="text-xs font-semibold uppercase tracking-widest text-orange-100 mb-1">Pending Payments</p>
        <h3 class="text-4xl font-extrabold">{{ $pendingCount }}</h3>
        <p class="text-xs text-orange-100 mt-2">Awaiting review</p>
        <i class="fas fa-clock text-4xl text-white/20 absolute right-6 bottom-5 group-hover:text-white/40 transition-all duration-300"></i>
    </a>

    <a href="{{ route('admin.materials.index') }}"
       class="stat-card card-glow relative bg-gradient-to-br from-violet-500 to-purple-700 text-white p-6 rounded-2xl shadow-lg overflow-hidden group cursor-pointer">
        <div class="absolute -right-5 -top-5 w-24 h-24 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
        <div class="absolute right-2 -bottom-8 w-32 h-32 bg-white/5 rounded-full"></div>
        <p class="text-xs font-semibold uppercase tracking-widest text-violet-200 mb-1">Training Materials</p>
        <h3 class="text-4xl font-extrabold">{{ $materialsCount }}</h3>
        <p class="text-xs text-violet-200 mt-2">PDFs uploaded</p>
        <i class="fas fa-file-pdf text-4xl text-white/20 absolute right-6 bottom-5 group-hover:text-white/40 transition-all duration-300"></i>
    </a>

</div>

{{-- ── Add Advert ── --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <div class="flex items-center gap-2 mb-5">
        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
            <i class="fas fa-bullhorn text-blue-500 text-sm"></i>
        </div>
        <h2 class="text-base font-bold text-slate-800">Add Advert</h2>
    </div>
    <form action="{{ route('admin.adverts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Title</label>
                <input type="text" name="title" placeholder="Enter title" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 placeholder-slate-300
                              focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition bg-slate-50">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Note</label>
                <input type="text" name="note" placeholder="Enter note" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 placeholder-slate-300
                              focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition bg-slate-50">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Image</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm bg-slate-50 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-blue-200 transition-all duration-200 hover:shadow-lg hover:shadow-blue-300">
                <i class="fas fa-plus text-xs"></i> Add Advert
            </button>
        </div>
    </form>
</div>

{{-- ── Trainees Table ── --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- Table Header --}}
    <div class="px-6 py-4 flex items-center justify-between border-b border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-slate-800 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-white text-xs"></i>
            </div>
            <div>
                <h2 class="text-sm font-bold text-slate-800">Recent Trainees</h2>
                <p class="text-xs text-slate-400">Latest registrations</p>
            </div>
        </div>
        <a href="{{ route('admin.trainees') }}"
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 px-3.5 py-2 rounded-xl transition-all duration-200">
            See All <i class="fas fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/70">
                    <th class="px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Registered</th>
                    <th class="px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Payment Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($recentTrainees as $i => $trainee)
                <tr class="hover:bg-blue-50/40 transition-colors duration-150 group cursor-default">
                    <td class="px-6 py-4 text-slate-300 text-xs font-mono">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center text-xs font-bold text-slate-600 flex-shrink-0">
                                {{ strtoupper(substr($trainee->name, 0, 1)) }}
                            </div>
                            <span class="font-semibold text-slate-800 group-hover:text-blue-700 transition-colors">{{ $trainee->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-xs">{{ $trainee->email }}</td>
                    <td class="px-6 py-4 text-slate-500 text-xs font-mono">{{ $trainee->payments->first()?->phone ?? '—' }}</td>
                    <td class="px-6 py-4 text-slate-400 text-xs">{{ $trainee->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        @php $p = $trainee->payments->first(); @endphp
                        @if($p?->status === 'approved')
                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-xs px-3 py-1.5 rounded-full font-semibold border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> Approved
                            </span>
                        @elseif($p?->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 text-xs px-3 py-1.5 rounded-full font-semibold border border-amber-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span> Pending
                            </span>
                        @elseif($p?->status === 'rejected')
                            <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-xs px-3 py-1.5 rounded-full font-semibold border border-red-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span> Rejected
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-slate-50 text-slate-500 text-xs px-3 py-1.5 rounded-full font-semibold border border-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 inline-block"></span> No Payment
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fas fa-users text-3xl text-slate-200"></i>
                            <p class="text-slate-400 text-sm">No trainees registered yet</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
