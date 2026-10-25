@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">የስልጠና መማሪያዎች</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($materials as $material)
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900">{{ $material->title }}</h2>
                    <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-bold uppercase">{{ $material->type }}</span>
                </div>
                <p class="text-gray-500 text-sm">{{ $material->description }}</p>

                @if($material->type === 'pdf')
                    <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                       class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg transition text-sm">
                        <i class="fas fa-file-pdf"></i> PDF 
                    </a>
                @elseif($material->type === 'video')
                    <video controls class="w-full rounded-lg shadow">
                        <source src="{{ asset('storage/' . $material->file_path) }}" type="video/mp4">
                    </video>
                @endif
            </div>
        @empty
            <div class="col-span-2 text-center py-12 text-gray-400">ምንም ቁሳቁስ አልተጫነም።</div>
        @endforelse
    </div>
</div>
@endsection
