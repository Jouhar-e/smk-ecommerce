@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Tambah Produk</h1>

    <div class="bg-white rounded-2xl border border-slate-200 p-4 max-w-2xl">
        <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Nama Produk</label>
                    <input type="text" name="item" value="{{ old('item') }}"
                        class="w-full rounded-lg border-slate-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Kategori</label>
                    <select name="category_id" class="w-full rounded-lg border-slate-300 text-sm">
                        <option value="">Pilih...</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                                {{ $cat->category }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full rounded-lg border-slate-300 text-sm">{{ old('description') }}</textarea>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Harga</label>
                    <input type="number" name="price" value="{{ old('price') }}"
                        class="w-full rounded-lg border-slate-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}"
                        class="w-full rounded-lg border-slate-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Ketersediaan</label>
                    <select name="availability" class="w-full rounded-lg border-slate-300 text-sm">
                        @foreach (['in_stock', 'low_stock', 'out_of_stock', 'preorder'] as $a)
                            <option value="{{ $a }}" @selected(old('availability') == $a)>
                                {{ strtoupper(str_replace('_', ' ', $a)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300"
                    @checked(old('is_active', true))>
                <span class="text-xs text-slate-600">Produk aktif</span>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Gambar Produk</label>
                <input type="file" name="image" class="w-full text-sm">
                <p class="text-[11px] text-slate-400 mt-1">Format: JPG/PNG, maks 2MB.</p>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                    Simpan
                </button>
                <a href="{{ route('admin.items.index') }}"
                    class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
