@extends('layouts.main')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Ubah Password</h2>

        @if (session('success'))
            <div class="mb-3 p-2 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            {{-- Password Lama --}}
            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700 mb-1">Password Lama</label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm pr-16" required>
                    <button type="button" onclick="togglePassword('current_password', this)"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-indigo-600 font-medium">
                        Lihat
                    </button>
                </div>
                @error('current_password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                <div class="relative">
                    <input type="password" name="new_password" id="new_password"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm pr-16" required>
                    <button type="button" onclick="togglePassword('new_password', this)"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-indigo-600 font-medium">
                        Lihat
                    </button>
                </div>
                @error('new_password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm pr-16" required>
                    <button type="button" onclick="togglePassword('new_password_confirmation', this)"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-indigo-600 font-medium">
                        Lihat
                    </button>
                </div>
            </div>

            <button type="submit" class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-indigo-700">
                Simpan Perubahan
            </button>
        </form>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
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
