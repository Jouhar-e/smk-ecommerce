@extends('layouts.main')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-xl font-semibold">Produk</h1>
            <p class="text-sm text-slate-500">Kelola daftar produk.</p>
        </div>
        <a href="{{ route('admin.items.create') }}"
            class="inline-flex items-center px-3 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
            + Tambah Produk
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-4 text-sm">
        {{-- SEARCH BAR --}}
        <form method="GET" action="{{ route('admin.items.index') }}" class="mb-4 flex gap-2 justify-end">
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari produk / kategori..."
                class="w-full md:w-64 rounded-xl border-slate-300 text-sm px-3 py-1.5">
            <button class="px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-700">
                Cari
            </button>
        </form>

        <div class="overflow-x-auto">
            {{-- tabel yang lama tetap --}}

            <table class="min-w-full">
                <thead>
                    <tr class="border-b text-xs text-slate-500">
                        <th class="py-2 text-left">Produk</th>
                        <th class="py-2 text-left">Kategori</th>
                        <th class="py-2 text-left">Harga</th>
                        <th class="py-2 text-left">Stok</th>
                        <th class="py-2 text-left">Status</th>
                        <th class="py-2 text-left"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr class="border-b last:border-b-0">
                            <td class="py-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden">
                                        @if ($item->path)
                                            <img src="{{ asset('storage/' . $item->path) }}"
                                                class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold">{{ $item->item }}</div>
                                        <div class="text-xs text-slate-500 line-clamp-1">
                                            {{ $item->description }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">
                                {{ $item->category->category ?? '-' }}
                            </td>
                            <td class="py-2">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="py-2">
                                {{ $item->stock }}
                            </td>
                            <td class="py-2 text-xs">
                                @if ($item->is_active)
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
                                <a href="{{ route('admin.items.edit', $item) }}"
                                    class="text-indigo-600 hover:underline mr-2">
                                    Edit
                                </a>
                                <form action="{{ route('admin.items.destroy', $item) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-slate-500">
                                Belum ada produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $items->links() }}
        </div>
    </div>
@endsection
