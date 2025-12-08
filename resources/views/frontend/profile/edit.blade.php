@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Profil Saya</h1>

    <div class="bg-white rounded-2xl border border-slate-200 p-4 max-w-xl">
        <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs text-slate-500 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full rounded-lg border-slate-300 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Email (tidak bisa diubah)</label>
                <input type="email" value="{{ $user->email }}" disabled
                    class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">No. Telepon</label>
                <input type="text" name="telp" value="{{ old('telp', $user->telp) }}"
                    class="w-full rounded-lg border-slate-300 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full rounded-lg border-slate-300 text-sm">{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            <button type="submit"
                class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                Simpan Perubahan
            </button>
        </form>
    </div>
@endsection
