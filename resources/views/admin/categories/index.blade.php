@extends('layouts.main')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-xl font-semibold">Kategori</h1>
            <p class="text-sm text-slate-500">Kelola kategori produk.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
            class="inline-flex items-center px-3 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
            + Tambah Kategori
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-3 sm:p-4 text-sm">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="mb-4 flex gap-2 justify-end">
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari kategori..."
                class="w-full md:w-64 rounded-xl border-slate-300 text-sm px-3 py-1.5">
            <button class="px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-700">
                Cari
            </button>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200 p-3 sm:p-4 text-sm">
            <div class="overflow-x-auto -mx-2 sm:mx-0">
                <table class="min-w-full text-xs sm:text-sm border-collapse">
                    <thead>
                        <tr class="border-b text-[11px] sm:text-xs text-slate-500">
                            <th class="py-2 px-2 text-left">#</th>
                            <th class="py-2 px-2 text-left">Kategori</th>
                            <th class="py-2 px-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-b last:border-b-0">
                                <td class="py-2 px-2 align-top">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="py-2 px-2 align-top">
                                    {{ $category->category }}
                                </td>

                                <td class="py-2 px-2 align-top text-right whitespace-nowrap">
                                    <div class="inline-flex gap-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                            class="text-indigo-600 hover:underline text-xs">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-slate-500">
                                    Belum ada kategori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
