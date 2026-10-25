@extends('layouts.app')
@section('title', 'Trainee Dashboard - YG Training')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-xl text-sm">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    {{-- Welcome --}}
    @if($payment?->status === 'approved')
    <div id="welcome-banner" class="bg-[#1d3557] text-white rounded-2xl p-6 flex items-center justify-between shadow transition-all duration-500">
        <div>
            <h1 class="text-xl font-bold">እንኳን ደህና መጡ፣ {{ Auth::user()->name }}!</h1>
            <p class="text-blue-200 text-sm mt-1">YG Training and Consultancy</p>
        </div>
        <span class="bg-emerald-500 text-white text-xs font-bold px-4 py-2 rounded-full">✓ Approved</span>
    </div>
    <script>
        setTimeout(function() {
            var banner = document.getElementById('welcome-banner');
            if (banner) {
                banner.style.opacity = '0';
                banner.style.transform = 'scaleY(0)';
                banner.style.maxHeight = '0';
                banner.style.padding = '0';
                banner.style.margin = '0';
                banner.style.overflow = 'hidden';
            }
        }, 60000); // 1 minute
    </script>
    @else
    <div class="bg-[#1d3557] text-white rounded-2xl p-6 flex items-center justify-between shadow">
        <div>
            <h1 class="text-xl font-bold">እንኳን ደህና መጡ፣ {{ Auth::user()->name }}!</h1>
            <p class="text-blue-200 text-sm mt-1">YG Training and Consultancy</p>
        </div>
        @if($payment?->status === 'pending')
            <span class="bg-amber-400 text-white text-xs font-bold px-4 py-2 rounded-full">⏳ Pending Review</span>
        @else
            <span class="bg-slate-500 text-white text-xs font-bold px-4 py-2 rounded-full">Not Registered</span>
        @endif
    </div>
    @endif

    {{-- Adverts --}}
    @if($announcements->count() > 0)
    <div>
        <h2 class="text-lg font-bold text-gray-800 mb-4">አዳዲስ ማስታወቂያዎች</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($announcements as $advert)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                @if($advert->image)
                    <img src="{{ asset('storage/' . $advert->image) }}" class="h-44 w-full object-cover">
                @endif
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-bold text-gray-800">{{ $advert->title }}</h3>
                    <p class="text-sm text-gray-500 mt-1 line-clamp-2 flex-1">{{ $advert->note }}</p>
                    <button onclick="openAdvertModal('{{ addslashes($advert->title) }}', '{{ addslashes($advert->note) }}', '{{ $advert->image ? asset('storage/' . $advert->image) : '' }}')"
                            class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 transition self-start">
                        More <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Register to Training button / form --}}
    @if(!$payment || $payment->status === 'rejected')
    <div x-data="{ open: false }">

        <button @click="open = !open"
                class="inline-flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-7 py-3.5 rounded-full shadow-lg transition text-sm">
            <i class="fas fa-user-plus"></i>
            Register to Training
        </button>

        {{-- Registration Form --}}
        <div x-show="open" x-transition
             class="mt-6 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 max-w-lg">
            <h3 class="text-base font-bold text-slate-800 mb-5">
                <i class="fas fa-clipboard-list text-blue-500 mr-2"></i>Training Registration Form
            </h3>

            <form action="{{ route('payment.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name', Auth::user()->name) }}" required
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('full_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="+251 9XX XXX XXX"
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Payment Screenshot</label>
                    <input type="file" name="screenshot" accept="image/*" required
                           class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm">
                    @error('screenshot')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-xl text-sm font-bold transition shadow-md">
                    <i class="fas fa-paper-plane text-xs"></i> Submit Registration
                </button>
            </form>

            <div class="mt-6">
            {{-- Training Price --}}
            <div class="mb-4 bg-gradient-to-r from-[#1a1a2e] via-[#16213e] to-[#0f3460] text-white rounded-xl p-4 flex items-center justify-between shadow-lg border border-white/10">
                <div>
                    <p class="text-xs text-slate-300 font-medium uppercase tracking-widest">Training Fee</p>
                    <p class="text-2xl font-extrabold mt-0.5 text-amber-400">ETB {{ number_format($trainingPrice) }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-tag text-white text-lg"></i>
                </div>
            </div>

            {{-- Payment Account Info --}}
            <div class="mt-5 bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm">
                <p class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-info-circle"></i> Pay to this account
                </p>
                <div class="space-y-2 text-slate-700">
                    <div class="flex items-center justify-between bg-white rounded-lg px-3 py-2 border border-blue-100">
                        <span class="text-xs text-slate-500">Bank Account</span>
                        <span class="font-mono font-bold tracking-wide">1000222315917</span>
                    </div>
                    <div class="flex items-center justify-between bg-white rounded-lg px-3 py-2 border border-blue-100">
                        <span class="text-xs text-slate-500">Account Name</span>
                        <span class="font-semibold">Zekarias Getachew</span>
                    </div>
                    <div class="flex items-center justify-between bg-white rounded-lg px-3 py-2 border border-blue-100">
                        <span class="text-xs text-slate-500">Telebirr</span>
                        <span class="font-mono font-bold tracking-wide">0930858986</span>
                    </div>
                </div>
                <p class="text-xs text-blue-600 mt-3">After payment, upload your screenshot above.</p>
            </div>
        </div>
    </div>

    @elseif($payment->status === 'pending')
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 text-sm text-amber-800">
        <i class="fas fa-clock mr-2"></i>
        Your registration has been submitted. Please wait for admin approval.
    </div>

    @elseif($payment->status === 'approved')
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 text-sm text-emerald-800">
        <i class="fas fa-check-circle mr-2"></i>
        Your registration is approved! <a href="{{ route('materials.index') }}" class="font-bold underline ml-4">Go to Training Materials →</a>
    </div>
    @endif

</div>

{{-- Advert Detail Modal --}}
<div id="advertModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; padding:16px;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden">
        <img id="modalImg" src="" class="w-full h-56 object-cover hidden">
        <div class="p-6">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-800 mb-3"></h3>
            <p id="modalNote" class="text-sm text-gray-600 leading-relaxed whitespace-pre-line"></p>
            <button onclick="closeAdvertModal()"
                    class="mt-5 w-full bg-slate-100 hover:bg-slate-200 text-slate-700 py-2.5 rounded-xl text-sm font-semibold transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function openAdvertModal(title, note, img) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalNote').textContent = note;
    var imgEl = document.getElementById('modalImg');
    if (img) { imgEl.src = img; imgEl.classList.remove('hidden'); }
    else { imgEl.classList.add('hidden'); }
    document.getElementById('advertModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeAdvertModal() {
    document.getElementById('advertModal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('advertModal').addEventListener('click', function(e) {
    if (e.target === this) closeAdvertModal();
});
</script>

@endsection
