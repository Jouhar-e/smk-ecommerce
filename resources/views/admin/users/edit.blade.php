@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Edit Pengguna</h1>

    <div class="bg-white rounded-2xl border border-slate-200 p-4 max-w-md text-sm">
        <div class="mb-4">
            <div class="font-semibold">{{ $user->name }}</div>
            <div class="text-xs text-slate-500">{{ $user->email }}</div>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs text-slate-500 mb-1">Level</label>
                <select name="level" class="w-full rounded-lg border-slate-300 text-sm">
                    @foreach (['admin', 'seller', 'customer'] as $level)
                        <option value="{{ $level }}" @selected(old('level', $user->level) == $level)>
                            {{ ucfirst($level) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Status</label>
                <select name="status" class="w-full rounded-lg border-slate-300 text-sm">
                    <option value="1" @selected(old('status', $user->status) == 1)>Aktif</option>
                    <option value="0" @selected(old('status', $user->status) == 0)>Nonaktif</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                    Simpan
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
