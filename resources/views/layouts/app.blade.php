<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') · FinTrack</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
    @fluxAppearance
    <style>
        [x-cloak] { display: none !important; }
        #fintrack-sidebar {
            transition: transform .3s ease;
        }
        #fintrack-main {
            transition: margin-left .3s ease;
        }
        #fintrack-overlay {
            display: none;
        }
        @media (min-width: 1024px) {
            #fintrack-sidebar.is-closed {
                transform: translateX(-100%);
            }
            #fintrack-main.is-expanded {
                margin-left: 0;
            }
        }
        @media (max-width: 1023px) {
            #fintrack-sidebar {
                transform: translateX(-100%);
            }
            #fintrack-sidebar.is-open {
                transform: translateX(0);
            }
            #fintrack-overlay.is-visible {
                display: block;
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

<div class="min-h-screen">

    <!-- LAPISAN GELAP HP -->
    <div id="fintrack-overlay"
         class="fixed inset-0 z-40 bg-slate-950/50"
         onclick="closeFintrackMenu()"></div>

    <!-- SIDEBAR -->
    <aside id="fintrack-sidebar"
        class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col bg-[#101f46] text-white shadow-xl">

        <div class="flex h-20 shrink-0 items-center gap-3 border-b border-white/10 px-6">
            <div class="grid h-10 w-10 place-items-center rounded-xl bg-sky-400 text-xl font-black text-[#10234b]">F</div>
            <div>
                <div class="text-lg font-bold tracking-wide">FinTrack</div>
                <div class="text-xs text-blue-200">Personal Finance</div>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6 text-sm">
            <p class="px-3 pb-3 text-[10px] font-bold uppercase tracking-[.18em] text-blue-300/70">Menu utama</p>

            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                ▦ <span>Dashboard</span>
            </a>

            <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.*') && !request()->routeIs('transaksi.history') ? 'nav-active' : '' }}">
                ↔ <span>Transaksi</span>
            </a>

            <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'nav-active' : '' }}">
                ▤ <span>Kategori</span>
            </a>

            <a href="{{ route('transaksi.history') }}" class="nav-link {{ request()->routeIs('transaksi.history') ? 'nav-active' : '' }}">
                ◷ <span>Riwayat</span>
            </a>

            <p class="px-3 pb-2 pt-8 text-[10px] font-bold uppercase tracking-[.18em] text-blue-300/70">Akun</p>

            <div class="rounded-xl bg-white/5 p-3">
                <div class="truncate text-sm font-semibold">{{ auth()->user()->name }}</div>
                <div class="truncate text-xs text-blue-200">{{ auth()->user()->email }}</div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button class="nav-link w-full text-left text-blue-100 hover:bg-white/10">
                    ↪ <span>Keluar</span>
                </button>
            </form>
        </nav>

        <div class="m-4 shrink-0 rounded-2xl border border-white/10 bg-white/5 p-4 text-xs leading-5 text-blue-100">
            Catat setiap transaksi kecil. Kebiasaan baik dimulai dari sini.
        </div>
    </aside>

    <!-- KONTEN -->
    <div id="fintrack-main" class="min-w-0 lg:ml-64">

        <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white/95 px-4 backdrop-blur sm:h-20 sm:px-8">

            <div class="flex min-w-0 items-center gap-3">

                <!-- TOMBOL MENU SELALU TERLIHAT -->
                <button
                    type="button"
                    onclick="toggleFintrackMenu()"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-slate-300 bg-white text-2xl text-slate-700 shadow-sm hover:bg-slate-100"
                    aria-label="Buka atau tutup menu"
                >
                    ☰
                </button>

                <div class="min-w-0">
                    <p class="truncate text-xs font-medium text-slate-400">Personal Finance Manager</p>
                    <h1 class="truncate text-lg font-bold text-[#14264f]">
                        @yield('page-title','Dashboard')
                    </h1>
                </div>
            </div>

            <div class="hidden items-center gap-3 sm:flex">
                <span class="text-sm text-slate-500">Halo, {{ auth()->user()->name }}</span>
                <div class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-sky-100 font-bold text-sky-700">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>
            </div>
        </header>

        <main class="mx-auto w-full max-w-7xl px-4 py-5 sm:px-8 sm:py-7">
           
@if(session('success'))
    <div class="mb-5 flex items-center justify-between rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
        <span>✓ {{ session('success') }}</span>

        <button
            type="button"
            onclick="this.parentElement.remove()"
            class="ml-4 text-lg font-bold hover:text-emerald-950"
            aria-label="Tutup notifikasi"
        >
            ×
        </button>
    </div>
@endif


            @if($errors->any())
                <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <ul class="list-inside list-disc">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="px-4 pb-6 text-center text-xs text-slate-400 sm:px-8">
            © {{ date('Y') }} FinTrack · Kelola keuangan dengan lebih terarah
        </footer>
    </div>
</div>

<script>
    function toggleFintrackMenu() {
        const sidebar = document.getElementById('fintrack-sidebar');
        const main = document.getElementById('fintrack-main');
        const overlay = document.getElementById('fintrack-overlay');

        if (window.innerWidth >= 1024) {
            sidebar.classList.toggle('is-closed');
            main.classList.toggle('is-expanded');
        } else {
            sidebar.classList.toggle('is-open');
            overlay.classList.toggle('is-visible');
        }
    }

    function closeFintrackMenu() {
        document.getElementById('fintrack-sidebar').classList.remove('is-open');
        document.getElementById('fintrack-overlay').classList.remove('is-visible');
    }
</script>

@livewireScripts
@fluxScripts
</body>
</html>
