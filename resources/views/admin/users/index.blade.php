@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Pengguna</h1>

    <div class="bg-white rounded-2xl border border-slate-200 p-4 text-sm">
        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex gap-2 justify-end">
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama / email / telp..."
                class="w-full md:w-72 rounded-xl border-slate-300 text-sm px-3 py-1.5">
            <button class="px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-700">
                Cari
            </button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                {{-- tabelmu yang lama --}}

                <thead>
                    <tr class="border-b text-xs text-slate-500">
                        <th class="py-2 text-left">Nama</th>
                        <th class="py-2 text-left">Email</th>
                        <th class="py-2 text-left">Level</th>
                        <th class="py-2 text-left">Status</th>
                        <th class="py-2 text-left"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b last:border-b-0">
                            <td class="py-2">
                                {{ $user->name }}
                            </td>
                            <td class="py-2">
                                {{ $user->email }}
                            </td>
                            <td class="py-2 text-xs uppercase">
                                {{ $user->level }}
                            </td>
                            <td class="py-2 text-xs">
                                @if ($user->status)
                                    <span
                                        class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Aktif
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-0.5 rounded-full bg-slate-50 text-slate-600 border border-slate-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-2 text-right text-xs">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:underline">
                                    Ubah
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-slate-500">
                                Belum ada pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
