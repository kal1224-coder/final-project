@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <!-- Hero Banner & Announcement -->
    <div class="bg-blue-900 text-white rounded-2xl p-8 mb-12 shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="md:w-1/2 space-y-4">
            <h1 class="text-4xl font-extrabold leading-tight">Welcome To YG Training & Consultancy </h1>
            <p class="text-blue-100 text-lg">ክህሎትዎን ያሳድጉ፣ የወደፊት ጉዞዎን በተግባራዊ ስልጠናዎች ያፋጥኑ።</p>
            <a href="{{ route('register') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold px-6 py-3 rounded-lg shadow-md transition">አሁኑኑ ይመዝገቡ</a>
        </div>
        <div class="md:w-1/2">
            <img src="https://via.placeholder.com/600x350" alt="YG Training Banner" class="rounded-xl shadow-lg w-full object-cover">
        </div>
    </div>

    <!-- Advertisements & Notes Section -->
    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-l-4 border-blue-900 pl-3">አዳዲስ ማስታወቂያዎችና ስልጠናዎች</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
       @forelse($announcements ?? [] as $announcement)
    <div class="bg-white rounded-xl shadow-md p-4">
        <img src="{{ asset('storage/' . $announcement->image) }}" class="h-48 w-full object-cover">
        <h3 class="font-bold">{{ $announcement->title }}</h3>
    </div>
@empty
    <p>ምንም ማስታወቂያ የለም።</p>
@endforelse
    </div>
</div>
@endsection