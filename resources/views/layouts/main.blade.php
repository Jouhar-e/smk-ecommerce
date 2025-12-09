<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? ($profile->store_name ?? config('app.name')) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Favicon dinamis dari logo toko --}}
    @if (!empty($profile?->logo_path) && file_exists(storage_path('app/public/' . $profile->logo_path)))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $profile->logo_path) }}">
    @else
        {{-- fallback kalau logo belum ada --}}
        <link rel="icon" type="image/png" href="{{ asset('default-favicon.png') }}">
    @endif
</head>


<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <header class="border-b bg-white/80 backdrop-blur sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            {{-- LOGO + NAMA TOKO --}}
            <div class="flex items-center gap-3">
                @if (!empty($profile?->logo_path) && file_exists(storage_path('app/public/' . $profile->logo_path)))
                    <img src="{{ asset('storage/' . $profile->logo_path) }}"
                        alt="{{ $profile->store_name ?? 'Logo Toko' }}" class="h-12 w-auto object-contain">
                @else
                    <div
                        class="h-10 w-10 rounded-lg bg-indigo-500 flex items-center justify-center text-white font-bold">
                        {{ substr($profile->store_name ?? 'TS', 0, 2) }}
                    </div>
                @endif
                <div>
                    <div class="font-semibold text-lg">
                        {{ $profile->store_name ?? 'Toko SMK' }}
                    </div>
                    @if (!empty($profile?->tagline))
                        <div class="text-xs text-slate-500">
                            {{ $profile->tagline }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- NAV DESKTOP --}}
            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a href="{{ route('home') }}"
                    class="hover:text-indigo-600 {{ request()->routeIs('home') ? 'text-indigo-600 font-semibold' : '' }}">
                    Beranda
                </a>
                @auth
                    <a href="{{ route('orders.index') }}"
                        class="hover:text-indigo-600 {{ request()->routeIs('orders.*') ? 'text-indigo-600 font-semibold' : '' }}">
                        Pesanan
                    </a>
                    <a href="{{ route('cart.index') }}"
                        class="hover:text-indigo-600 {{ request()->routeIs('cart.*', 'checkout.*') ? 'text-indigo-600 font-semibold' : '' }}">
                        Keranjang
                    </a>
                    <a href="{{ route('customer.profile.edit') }}"
                        class="hover:text-indigo-600 {{ request()->routeIs('customer.profile.*') ? 'text-indigo-600 font-semibold' : '' }}">
                        Profil
                    </a>
                    @if (auth()->user()->level === 'admin' || auth()->user()->level === 'seller')
                        <a href="{{ route('admin.dashboard') }}"
                            class="hover:text-indigo-600 {{ str_starts_with(request()->route()->getName(), 'admin.') ? 'text-indigo-600 font-semibold' : '' }}">
                            Admin
                        </a>
                    @endif
                @endauth
            </nav>

            {{-- AKSI KANAN (DESKTOP) --}}
            <div class="hidden md:flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="text-sm text-slate-600 hover:text-indigo-600">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700">
                        Daftar
                    </a>
                @else
                    <span class="hidden sm:inline text-sm text-slate-600">
                        {{ auth()->user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium border border-slate-200 hover:bg-slate-100">
                            Keluar
                        </button>
                    </form>
                @endguest
            </div>

            {{-- BUTTON HAMBURGER (MOBILE) --}}
            <button id="mobile-menu-toggle"
                class="md:hidden inline-flex items-center justify-center p-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100">
                <span class="sr-only">Toggle menu</span>
                ☰
            </button>
        </div>

        {{-- NAVBAR MOBILE (DROPDOWN) --}}
        <div id="mobile-menu" class="md:hidden border-t bg-white hidden">
            <div class="max-w-6xl mx-auto px-4 py-3 space-y-2 text-sm">
                <a href="{{ route('home') }}"
                    class="block py-1 {{ request()->routeIs('home') ? 'text-indigo-600 font-semibold' : 'text-slate-700' }}">
                    Beranda
                </a>

                @auth
                    <a href="{{ route('orders.index') }}"
                        class="block py-1 {{ request()->routeIs('orders.*') ? 'text-indigo-600 font-semibold' : 'text-slate-700' }}">
                        Pesanan
                    </a>
                    <a href="{{ route('cart.index') }}"
                        class="block py-1 {{ request()->routeIs('cart.*', 'checkout.*') ? 'text-indigo-600 font-semibold' : 'text-slate-700' }}">
                        Keranjang
                    </a>
                    <a href="{{ route('customer.profile.edit') }}"
                        class="block py-1 {{ request()->routeIs('customer.profile.*') ? 'text-indigo-600 font-semibold' : 'text-slate-700' }}">
                        Profil
                    </a>
                    @if (auth()->user()->level === 'admin' || auth()->user()->level === 'seller')
                        <a href="{{ route('admin.dashboard') }}"
                            class="block py-1 {{ str_starts_with(request()->route()->getName(), 'admin.') ? 'text-indigo-600 font-semibold' : 'text-slate-700' }}">
                            Admin
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="pt-2">
                        @csrf
                        <button class="w-full text-left py-1 text-slate-700">
                            Keluar
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="block py-1 text-slate-700">Masuk</a>
                    <a href="{{ route('register') }}" class="block py-1 text-slate-700">Daftar</a>
                @endguest
            </div>
        </div>
    </header>

    {{-- KONTEN UTAMA (flex-1 supaya dorong footer ke bawah) --}}
    <main class="flex-1">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="border-t bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 grid md:grid-cols-3 gap-6 text-sm text-slate-600">
            <div>
                <div class="font-semibold mb-1">{{ $profile->store_name ?? 'Toko SMK' }}</div>
                <p class="text-slate-500">
                    {{ $profile->description ?? 'Toko latihan e-commerce untuk siswa.' }}
                </p>
            </div>
            <div>
                <div class="font-semibold mb-1">Kontak</div>
                <p>{{ $profile->address ?? '-' }}</p>
                <p>Telp/WA: {{ $profile->phone ?? '-' }}</p>
                <p>Email: {{ $profile->email ?? '-' }}</p>
            </div>
            <div>
                <div class="font-semibold mb-1">Jam Operasional</div>
                <p>{{ $profile->open_hours ?? '08.00 - 17.00' }}</p>
                <div class="mt-2 flex gap-3">
                    @if (!empty($profile?->instagram))
                        <a href="{{ $profile->instagram }}" target="_blank" class="hover:text-indigo-600">Instagram</a>
                    @endif
                    @if (!empty($profile?->facebook))
                        <a href="{{ $profile->facebook }}" target="_blank" class="hover:text-indigo-600">Facebook</a>
                    @endif
                    @if (!empty($profile?->tiktok))
                        <a href="{{ $profile->tiktok }}" target="_blank" class="hover:text-indigo-600">TikTok</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="text-center text-xs text-slate-400 pb-4">
            &copy; {{ date('Y') }} {{ $profile->store_name ?? 'Toko SMK' }}. All rights reserved.
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-toggle');
            const menu = document.getElementById('mobile-menu');

            if (btn && menu) {
                btn.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                });
            }
        });
    </script>


</body>

</html>
