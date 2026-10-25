@extends('layouts.app')
@section('title', 'Verify Your Email - YG Training')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-md border border-gray-100 p-8 space-y-6">

        {{-- Header --}}
        <div class="text-center">
            <div class="flex justify-center items-center font-extrabold text-5xl mb-3">
                <span class="text-[#00529B]">Y</span>
                <span class="text-[#F39C12]">G</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Verify Your Email</h2>
            <p class="text-sm text-gray-500 mt-2">
                We sent a 4-digit code to <strong>{{ Auth::user()->email }}</strong>
            </p>
            @if(config('app.debug') && Auth::user()->verification_code)
                <p class="mt-2 text-xs bg-yellow-100 text-yellow-800 px-3 py-1 rounded-lg inline-block">
                    Dev mode — code: <strong>{{ Auth::user()->verification_code }}</strong>
                </p>
            @endif
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-xl text-sm">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
            </div>
        @endif

        {{-- Code Input Form --}}
        <form action="{{ route('verify.code.submit') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2 text-center">
                    Enter your 4-digit code
                </label>
                {{-- 4 separate digit inputs --}}
                <div class="flex gap-3 justify-center" id="code-inputs">
                    <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                           class="w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:outline-none transition"
                           oninput="moveNext(this, 0)">
                    <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                           class="w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:outline-none transition"
                           oninput="moveNext(this, 1)">
                    <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                           class="w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:outline-none transition"
                           oninput="moveNext(this, 2)">
                    <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                           class="w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:outline-none transition"
                           oninput="moveNext(this, 3)">
                </div>
                {{-- Hidden combined input --}}
                <input type="hidden" name="code" id="combined-code">
            </div>

            <button type="submit" id="verify-btn"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold text-sm transition">
                <i class="fas fa-check mr-2"></i>Verify Email
            </button>
        </form>

        {{-- Resend --}}
        <div class="text-center">
            <p class="text-sm text-gray-500 mb-2">Didn't receive the code?</p>
            <form action="{{ route('verify.code.resend') }}" method="POST">
                @csrf
                <button type="submit"
                        class="text-blue-600 hover:underline text-sm font-semibold">
                    Resend Code
                </button>
            </form>
        </div>

        {{-- Logout --}}
        <div class="text-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="text-xs text-gray-400 hover:text-gray-600">Sign out</button>
            </form>
        </div>
    </div>
</div>

<script>
const inputs = document.querySelectorAll('#code-inputs input');

function moveNext(el, index) {
    el.value = el.value.replace(/[^0-9]/g, '');
    if (el.value && index < 3) inputs[index + 1].focus();
    updateHidden();
}

// Allow backspace to go back
inputs.forEach((input, i) => {
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && i > 0) {
            inputs[i - 1].focus();
        }
    });
});

function updateHidden() {
    document.getElementById('combined-code').value =
        Array.from(inputs).map(i => i.value).join('');
}
</script>
@endsection
