@extends('layouts.app')

@section('content')

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

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($announcements as $announcement)
            <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                @if($announcement->image)
                    <img src="{{ asset('storage/' . $announcement->image) }}" class="h-48 w-full object-cover">
                @endif
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-bold text-gray-800">{{ $announcement->title }}</h3>
                    <p class="text-sm text-gray-500 mt-1 line-clamp-2 flex-1">{{ $announcement->note }}</p>
                    <button onclick="openAdvertModal('{{ addslashes($announcement->title) }}', '{{ addslashes($announcement->note) }}', '{{ $announcement->image ? asset('storage/' . $announcement->image) : '' }}')"
                            class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 transition self-start">
                        More <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-400 py-12">No announcements yet.</div>
        @endforelse
    </div>

    {{-- Role-based quick-access buttons --}}
    @auth
        @if(Auth::user()->usertype === 'admin')
            <div class="mt-10 flex justify-center">
                <a href="{{ route('admin.trainees') }}"
                   class="inline-flex items-center gap-3 bg-[#0b132b] hover:bg-[#162447] text-white font-semibold px-8 py-4 rounded-full shadow-lg transition-all duration-200 text-base">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Go to Trainees
                </a>
            </div>
        @endif

        @if(Auth::user()->usertype === 'user')
            <div class="mt-10 flex justify-center">
                <a href="{{ route('materials.index') }}"
                   class="inline-flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-4 rounded-full shadow-lg transition-all duration-200 text-base">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Go to Training Center
                </a>
            </div>
        @endif
    @endauth
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
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/13.1.0/firebase-app.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  const firebaseConfig = {
    apiKey: "AIzaSyBaqB2Kb8MT-7_vBw-EHOP9hBO5gudhr9k",
    authDomain: "yg-consultancy-and-training.firebaseapp.com",
    projectId: "yg-consultancy-and-training",
    storageBucket: "yg-consultancy-and-training.firebasestorage.app",
    messagingSenderId: "190213430677",
    appId: "1:190213430677:web:0c5973891ecbafb7ca2a9c"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
</script>

@endsection
