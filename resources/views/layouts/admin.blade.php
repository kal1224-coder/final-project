<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — YG Training & Consultancy</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { transform: translateX(4px); }
        .card-glow:hover { box-shadow: 0 0 30px 6px rgba(134,239,172,0.4); }
        .stat-card { transition: transform 0.25s ease, box-shadow 0.25s ease; }
        .stat-card:hover { transform: translateY(-4px) scale(1.02); }
    </style>
</head>
<body class="bg-[#f0f2f5] text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

<div class="min-h-screen flex">

    {{-- ═══════════════ SIDEBAR ═══════════════ --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0d1b2a] flex flex-col
                  transition-transform duration-300 md:translate-x-0 md:static md:inset-0 shadow-2xl">

        {{-- Logo --}}
        <div class="h-[70px] flex items-center px-6 border-b border-white/5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="flex items-center font-black text-4xl leading-none tracking-tight">
                    <span class="text-[#3b82f6]">Y</span>
                    <span class="text-[#f59e0b]">G</span>
                </div>
                <div class="leading-tight">
                    <p class="text-white font-bold text-sm">Admin Panel</p>
                    <p class="text-slate-400 text-xs">Training & Consultancy</p>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="ml-auto md:hidden text-slate-400 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest px-3 mb-3">Main Menu</p>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium
                      {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-300 hover:bg-white/8 hover:text-white' }}">
                <i class="fas fa-grid-2 w-4 text-center"></i> Dashboard
            </a>

            <a href="{{ route('admin.trainees') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium
                      {{ request()->routeIs('admin.trainees') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-300 hover:bg-white/8 hover:text-white' }}">
                <i class="fas fa-users w-4 text-center"></i> Trainees
            </a>

            <a href="{{ route('admin.payments.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium
                      {{ request()->routeIs('admin.payments.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-300 hover:bg-white/8 hover:text-white' }}">
                <i class="fas fa-credit-card w-4 text-center"></i> Payments
            </a>

            <a href="{{ route('admin.materials.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium
                      {{ request()->routeIs('admin.materials.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-300 hover:bg-white/8 hover:text-white' }}">
                <i class="fas fa-file-pdf w-4 text-center"></i> Materials
            </a>

            <a href="{{ route('admin.adverts.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium
                      {{ request()->routeIs('admin.adverts.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-300 hover:bg-white/8 hover:text-white' }}">
                <i class="fas fa-bullhorn w-4 text-center"></i> Adverts
            </a>

            <a href="{{ route('admin.prices.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium
                      {{ request()->routeIs('admin.prices.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-300 hover:bg-white/8 hover:text-white' }}">
                <i class="fas fa-tag w-4 text-center"></i> Prices
            </a>

            <div class="pt-4 border-t border-white/5 mt-4">
                <a href="{{ route('home') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-emerald-400 hover:bg-emerald-500/10 hover:text-emerald-300">
                    <i class="fas fa-globe w-4 text-center"></i> Go to Home Page
                </a>
            </div>
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="sidebar-link w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:bg-red-500/10 hover:text-red-300 transition">
                    <i class="fas fa-arrow-right-from-bracket w-4 text-center"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 md:hidden" x-transition></div>

    {{-- ═══════════════ MAIN ═══════════════ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top Bar --}}
        <header class="h-[70px] bg-white border-b border-slate-100 flex items-center justify-between px-6 shadow-sm flex-shrink-0">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="text-base font-bold text-slate-800">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-slate-400">YG Training & Consultancy</p>
                </div>
            </div>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" @click.away="open = false"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-50 transition border border-transparent hover:border-slate-200">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                             class="w-9 h-9 rounded-xl object-cover ring-2 ring-blue-100">
                    @else
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center font-bold text-sm shadow-md">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    @endif
                    <div class="hidden sm:block text-left">
                        <p class="text-sm font-semibold text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Administrator</p>
                    </div>
                    <i class="fas fa-chevron-down text-slate-400 text-xs ml-1 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50"
                     style="display:none">
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 transition">
                        <i class="fas fa-user-pen text-slate-400 w-4"></i> Edit Profile
                    </a>
                    <div class="my-1 border-t border-slate-100"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition font-medium">
                            <i class="fas fa-arrow-right-from-bracket w-4"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6 space-y-6">

            @if(session('success'))
                <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-sm shadow-sm">
                    <i class="fas fa-circle-check text-emerald-500"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-2xl text-sm shadow-sm">
                    <i class="fas fa-circle-exclamation text-red-500"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
