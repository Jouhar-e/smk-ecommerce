@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Edit Produk</h1>

    <div class="bg-white rounded-2xl border border-slate-200 p-4 max-w-2xl">
        <form action="{{ route('admin.items.update', $item) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Nama Produk</label>
                    <input type="text" name="item" value="{{ old('item', $item->item) }}"
                        class="w-full rounded-lg border-slate-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Kategori</label>
                    <select name="category_id" class="w-full rounded-lg border-slate-300 text-sm">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $item->category_id) == $cat->id)>
                                {{ $cat->category }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full rounded-lg border-slate-300 text-sm">{{ old('description', $item->description) }}</textarea>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Harga</label>
                    <input type="number" name="price" value="{{ old('price', $item->price) }}"
                        class="w-full rounded-lg border-slate-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $item->stock) }}"
                        class="w-full rounded-lg border-slate-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Ketersediaan</label>
                    <select name="availability" class="w-full rounded-lg border-slate-300 text-sm">
                        @foreach (['in_stock', 'low_stock', 'out_of_stock', 'preorder'] as $a)
                            <option value="{{ $a }}" @selected(old('availability', $item->availability) == $a)>
                                {{ strtoupper(str_replace('_', ' ', $a)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300"
                    @checked(old('is_active', $item->is_active))>
                <span class="text-xs text-slate-600">Produk aktif</span>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Gambar Produk</label>
                @if ($item->path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $item->path) }}" class="w-24 h-24 rounded-lg object-cover">
                    </div>
                @endif
                <input type="file" name="image" class="w-full text-sm">
                <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika tidak ingin mengubah gambar.</p>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                    Update
                </button>
                <a href="{{ route('admin.items.index') }}"
                    class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
