@extends('layouts.main')

@section('content')
    <div class="min-h-[60vh] flex items-center justify-center">
        <div class="w-full max-w-md bg-white border border-slate-200 rounded-2xl shadow-sm px-5 py-6 sm:px-6 sm:py-7">
            <h1 class="text-lg sm:text-xl font-semibold text-center mb-1">Masuk</h1>
            <p class="text-xs sm:text-sm text-slate-500 text-center mb-5">
                Silakan login untuk melanjutkan.
            </p>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="email@example.com">
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="login_password" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm pr-16 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword('login_password', this)"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-[11px] text-indigo-600 font-medium">
                            Lihat
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember + Lupa Password --}}
                <div class="flex items-center justify-between text-xs sm:text-[13px]">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="remember" class="rounded border-slate-300">
                        <span class="text-slate-600">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">
                            Lupa password?
                        </a>
                    @endif
                </div>

                {{-- Tombol login --}}
                <button type="submit"
                    class="w-full inline-flex items-center justify-center rounded-lg bg-indigo-600 text-white text-sm font-semibold py-3 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Masuk
                </button>
            </form>

            {{-- Link ke register --}}
            <p class="mt-5 text-center text-xs sm:text-sm text-slate-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = 'Sembunyi';
            } else {
                input.type = 'password';
                btn.textContent = 'Lihat';
            }
        }
    </script>
@endsection
