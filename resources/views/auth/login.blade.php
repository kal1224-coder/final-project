@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center items-center bg-gray-50 py-12 px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-md border border-gray-100 space-y-6">

        <div class="text-center">
            <div class="flex justify-center items-center font-extrabold text-5xl mb-2">
                <span class="text-[#00529B]">Y</span>
                <span class="text-[#F39C12]">G</span>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900">Login</h2>
            <p class="mt-1 text-sm text-gray-500">እባክዎን የኢሜይል እና የይለፍ ቃልዎን ያስገቡ</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                    Remember me
                </label>
            </div>
            <button type="submit"
                class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                Login
            </button>
        </form>

        <p class="text-center text-sm text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:underline">Register</a>
        </p>
    </div>
</div>
@endsection
