@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Pengguna</h1>

    <div class="bg-white rounded-2xl border border-slate-200 p-3 sm:p-4 text-sm">
        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex gap-2 justify-end">
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama / email / telp..."
                class="w-full md:w-72 rounded-xl border-slate-300 text-sm px-3 py-1.5">
            <button class="px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-700">
                Cari
            </button>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200 p-3 sm:p-4 text-sm">
            <div class="overflow-x-auto -mx-2 sm:mx-0">
                <table class="min-w-full text-xs sm:text-sm border-collapse">
                    <thead>
                        <tr class="border-b text-[11px] sm:text-xs text-slate-500">
                            <th class="py-2 px-2 text-left">Nama</th>
                            <th class="py-2 px-2 text-left">Email</th>
                            <th class="py-2 px-2 text-center">Level</th>
                            <th class="py-2 px-2 text-center">Status</th>
                            <th class="py-2 px-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="border-b last:border-b-0">
                                <td class="py-2 px-2 align-top">
                                    <div class="font-medium">{{ $user->name }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $user->telp }}</div>
                                </td>

                                <td class="py-2 px-2 align-top">
                                    {{ $user->email }}
                                </td>

                                <td class="py-2 px-2 align-top text-center text-[11px] uppercase">
                                    {{ $user->level }}
                                </td>

                                <td class="py-2 px-2 align-top text-center text-[11px]">
                                    {{ $user->status ? 'Aktif' : 'Nonaktif' }}
                                </td>

                                <td class="py-2 px-2 align-top text-right whitespace-nowrap">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="text-indigo-600 hover:underline text-xs">
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

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>

    </div>
@endsection
