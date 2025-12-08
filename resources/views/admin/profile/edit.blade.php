@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Profil Toko</h1>

    <div class="grid md:grid-cols-[2fr,1fr] gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-4">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4 text-sm">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Nama Toko</label>
                        <input type="text" name="store_name" value="{{ old('store_name', $profile->store_name ?? '') }}"
                            class="w-full rounded-lg border-slate-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $profile->tagline ?? '') }}"
                            class="w-full rounded-lg border-slate-300 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs text-slate-500 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-slate-300 text-sm">{{ old('description', $profile->description ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs text-slate-500 mb-1">Alamat</label>
                    <textarea name="address" rows="2" class="w-full rounded-lg border-slate-300 text-sm">{{ old('address', $profile->address ?? '') }}</textarea>
                </div>

                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Telepon / WA</label>
                        <input type="text" name="phone" value="{{ old('phone', $profile->phone ?? '') }}"
                            class="w-full rounded-lg border-slate-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $profile->email ?? '') }}"
                            class="w-full rounded-lg border-slate-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Jam Buka</label>
                        <input type="text" name="open_hours" value="{{ old('open_hours', $profile->open_hours ?? '') }}"
                            class="w-full rounded-lg border-slate-300 text-sm">
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Instagram</label>
                        <input type="text" name="instagram" value="{{ old('instagram', $profile->instagram ?? '') }}"
                            class="w-full rounded-lg border-slate-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Facebook</label>
                        <input type="text" name="facebook" value="{{ old('facebook', $profile->facebook ?? '') }}"
                            class="w-full rounded-lg border-slate-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">TikTok</label>
                        <input type="text" name="tiktok" value="{{ old('tiktok', $profile->tiktok ?? '') }}"
                            class="w-full rounded-lg border-slate-300 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs text-slate-500 mb-1">Logo Toko</label>
                    <input type="file" name="logo" class="w-full text-sm">
                    <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika tidak ingin mengubah logo.</p>
                </div>

                <button type="submit"
                    class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                    Simpan Profil
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 text-sm">
            <h2 class="text-sm font-semibold mb-3">Preview</h2>
            <div class="flex items-center gap-3 mb-3">
                @if (!empty($profile?->logo_path))
                    <img src="{{ asset('storage/' . $profile->logo_path) }}" class="w-12 h-12 rounded-lg object-cover">
                @else
                    <div class="w-12 h-12 rounded-lg bg-indigo-500 flex items-center justify-center text-white font-bold">
                        {{ substr($profile->store_name ?? 'TS', 0, 2) }}
                    </div>
                @endif
                <div>
                    <div class="font-semibold">
                        {{ $profile->store_name ?? 'Nama Toko' }}
                    </div>
                    <div class="text-xs text-slate-500">
                        {{ $profile->tagline ?? 'Tagline toko' }}
                    </div>
                </div>
            </div>
            <div class="text-xs text-slate-500">
                <div class="mb-1">Alamat: {{ $profile->address ?? '-' }}</div>
                <div class="mb-1">Telp: {{ $profile->phone ?? '-' }}</div>
                <div class="mb-1">Email: {{ $profile->email ?? '-' }}</div>
                <div>Jam buka: {{ $profile->open_hours ?? '08.00 - 17.00' }}</div>
            </div>
        </div>
    </div>
@endsection
