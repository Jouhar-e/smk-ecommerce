@extends('layouts.main')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Profil Saya</h2>

        <form method="POST" action="{{ route('customer.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700 mb-1">Email (tidak bisa diubah)</label>
                <input type="email" value="{{ auth()->user()->email }}"
                    class="w-full border border-slate-200 bg-slate-50 rounded-lg px-3 py-2 text-sm" readonly>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700 mb-1">No. Telepon</label>
                <input type="text" name="telp" value="{{ old('telp', auth()->user()->telp) }}"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">{{ old('alamat', auth()->user()->alamat) }}</textarea>
            </div>

            <button type="submit" class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-indigo-700">
                Simpan Perubahan
            </button>
        </form>

        {{-- Tambahan: Tombol Ubah Password --}}
        <div class="mt-6 border-t pt-4 text-center">
            <p class="text-sm text-slate-500 mb-3">Ingin mengganti password?</p>
            <a href="{{ route('password.edit') }}"
                class="inline-flex items-center justify-center px-4 py-2 rounded-lg border border-indigo-500 text-indigo-600 text-sm font-medium hover:bg-indigo-50">
                Ubah Password
            </a>
        </div>
    </div>
@endsection
