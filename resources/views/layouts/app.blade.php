<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'YG Training and Consultancy')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="shortcut icon" href="/favicon.svg">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen justify-between text-gray-800">

   <nav class="bg-[#1d3557] text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-3">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 flex-shrink-0">
            <div class="flex items-center font-extrabold text-4xl leading-none tracking-tight">
                <span class="text-[#00529B]">Y</span>
                <span class="bg-gradient-to-b from-[#F39C12] to-[#D35400] bg-clip-text text-transparent">G</span>
            </div>
            <div class="flex flex-col leading-tight hidden sm:block">
                <span class="text-white text-xs font-semibold">Training and</span>
                <span class="text-white text-xs font-medium">Consultancy</span>
            </div>
        </a>

        <!-- Right Side -->
        <div class="flex items-center gap-2 text-sm font-medium ml-auto">
            <a href="{{ url('/') }}" class="hover:text-gray-200 transition px-2">Home</a>

            @guest
                <a href="{{ route('login') }}" class="hover:text-gray-200 transition px-2">Login</a>
                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg font-semibold transition text-xs sm:text-sm">
                    Register
                </a>
            @endguest

            @auth
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" @click.away="open = false"
                    class="flex items-center gap-1.5 bg-blue-900/80 hover:bg-blue-900 text-white px-3 py-1.5 rounded-lg border border-blue-400/30 transition focus:outline-none text-xs sm:text-sm max-w-[160px]">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                             class="w-6 h-6 rounded-full object-cover border border-blue-300 flex-shrink-0">
                    @else
                        <span class="flex-shrink-0">👤</span>
                    @endif
                    <span class="truncate">{{ Auth::user()->name }}</span>
                    <svg class="w-3 h-3 flex-shrink-0 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50 text-gray-800"
                     style="display: none;">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm hover:bg-gray-100 text-gray-700 transition">
                        <span>✏️</span> Edit Profile
                    </a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition font-medium">
                            <span>🚪</span> Logout
                        </button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </div>
</nav>

    <!-- Main Content Area -->
    <main class="mb-auto py-8 flex-grow">
        @yield('content')
    </main>

   <footer class="bg-[#0b1329] text-white py-10 px-6 mt-12 border-t border-gray-800">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
        
        <!-- Column 1 (በግራ በኩል): Address/Contact & Social Media -->
        <div class="space-y-6">
            <!-- አድራሻ እና ስልክ -->
            <div>
                <h3 class="text-xl font-bold mb-3 text-white">አድራሻ እና ስልክ</h3>
                <ul class="space-y-2 text-gray-300 text-sm">
                    <li class="flex items-center gap-2">
                        <i class="fas fa-phone text-blue-400"></i>
                        <span>+251 911 00 00 00 / +251 922 00 00 00</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-envelope text-blue-400"></i>
                        <span>info@ygtraining.com</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-blue-400"></i>
                        <span>አዲስ አበባ፣ ኢትዮጵያ</span>
                    </li>
                </ul>
            </div>

            <!-- ማህበራዊ ሚዲያ (Social Media) -->
            <div>
                <h3 class="text-xl font-bold mb-3 text-white">ማህበራዊ ሚዲያ (Social Media)</h3>
                <p class="text-gray-400 text-xs mb-3">በሰፊው ሚዲያ ገጾቻችንን በመከተል አዳዲስ መረጃዎችን ያግኙ፡</p>
                <div class="flex items-center gap-4 text-2xl">
                    <a href="https://t.me/ygchemicals1" target="_blank" class="text-sky-400 hover:text-sky-300 transition"><i class="fab fa-telegram"></i></a>
                    <a href="https://vt.tiktok.com/ZSVeUnpK4/" target="_blank" class="text-pink-500 hover:text-pink-400 transition"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>

        <!-- Column 2 (በቀኝ በኩል): ስለ ድርጅቱ (About Us) -->
        <div>
            <h3 class="text-xl font-bold mb-3 text-white">About Us</h3>
            <p class="text-gray-300 text-sm leading-relaxed">
                <span class="font-semibold text-white">YG Training and Consultancy</span> ጥራታቸውን የጠበቁ የሳሙና እና ኮስሞቲክስ ማምረቻ ቀመሮችን፣ የተግባር ስልጠናዎችን እና የቴክኒክ አማካሪነት አገልግሎቶችን ለግለሰቦችና ድርጅቶች የሚሰጥ ተቋም ነው።
            </p>
            <ul class="mt-3 space-y-1 text-gray-400 text-sm">
                <li>👉 የኬሚካል ምርት ቀመሮች ማዘጋጀት (Formulation & Development)</li>
                <li>👉 ተግባራዊ ስልጠናዎች (Manufacturing Training)</li>
                <li>👉 የባለሙያ አማካሪነት አገልግሎት (Consultancy)</li>
                <li>👉 የቴክኒክ ሰነዶች ዝግጅት (Document Preparation)</li>
                <li>👉 የምርት ጥናትና ምርምር (Chemical Research)</li>
            </ul>
        </div>

    </div>
</footer>
</div>
</body>
</html>