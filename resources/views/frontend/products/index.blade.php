@extends('layouts.main')

@section('content')
    <div class="flex flex-col gap-6">
        <section class="bg-gradient-to-r from-indigo-500 to-sky-500 rounded-2xl px-6 py-8 text-white shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold mb-2">
                        Selamat datang di {{ $profile->store_name ?? 'Toko SMK' }}
                    </h1>
                    <p class="text-sm md:text-base text-indigo-100 max-w-xl">
                        {{ $profile->tagline ?? 'Marketplace karya siswa dengan tampilan profesional.' }}
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="#products"
                        class="inline-flex items-center px-4 py-2 rounded-xl bg-white text-indigo-600 text-sm font-semibold shadow hover:bg-indigo-50">
                        Lihat Produk
                    </a>
                    @auth
                        <a href="{{ route('cart.index') }}"
                            class="inline-flex items-center px-4 py-2 rounded-xl border border-white/70 text-sm font-semibold hover:bg-white/10">
                            Lihat Keranjang
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <section class="grid md:grid-cols-[220px,1fr] gap-6" id="products">
            {{-- SIDEBAR KATEGORI --}}
            <aside class="bg-white rounded-2xl border border-slate-200 p-4 h-fit">
                <h2 class="font-semibold text-sm mb-3">Kategori</h2>
                <ul class="space-y-1 text-sm">
                    {{-- Semua kategori --}}
                    <li>
                        <a href="{{ route('home', ['q' => request('q')]) }}"
                            class="flex items-center justify-between px-2 py-1 rounded-lg
                                  {{ empty($currentCategoryId) ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'hover:bg-slate-50' }}">
                            <span>Semua</span>
                        </a>
                    </li>

                    @foreach ($categories as $cat)
                        <li>
                            <a href="{{ route('home', ['category' => $cat->id, 'q' => request('q')]) }}"
                                class="flex items-center justify-between px-2 py-1 rounded-lg
                                      {{ (int) $currentCategoryId === $cat->id ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'hover:bg-slate-50' }}">
                                <span>{{ $cat->category }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

            <div class="space-y-4">
                {{-- BAR ATAS: JUDUL + SEARCH --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h2 class="font-semibold text-sm text-slate-700">
                            @if ($currentCategoryId)
                                @php
                                    $currentCat = $categories->firstWhere('id', (int) $currentCategoryId);
                                @endphp
                                Produk: {{ $currentCat->category ?? 'Semua' }}
                            @else
                                Semua Produk
                            @endif
                        </h2>
                        <span class="text-xs text-slate-500">
                            {{ $items->total() }} produk
                        </span>
                    </div>

                    {{-- FORM PENCARIAN --}}
                    <form method="GET" action="{{ route('home') }}" class="flex items-center gap-2 w-full md:w-auto">
                        @if ($currentCategoryId)
                            <input type="hidden" name="category" value="{{ $currentCategoryId }}">
                        @endif
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama produk..."
                            class="w-full md:w-64 rounded-xl border-slate-300 text-sm px-3 py-1.5">
                        <button type="submit"
                            class="inline-flex items-center px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-700">
                            Cari
                        </button>
                    </form>
                </div>

                {{-- GRID PRODUK --}}
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($items as $item)
                        <a href="{{ route('products.show', $item) }}"
                            class="bg-white rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-md transition p-4 flex flex-col">
                            <div class="aspect-[4/3] rounded-xl bg-slate-100 mb-3 overflow-hidden">
                                @if ($item->path)
                                    <img src="{{ asset('storage/' . $item->path) }}" alt="{{ $item->item }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">
                                        Tidak ada gambar
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 flex flex-col">
                                <div class="text-xs text-slate-500 mb-1">
                                    {{ $item->category->category ?? '-' }}
                                </div>
                                <div class="font-semibold text-sm mb-1 line-clamp-2">
                                    {{ $item->item }}
                                </div>
                                <div class="text-indigo-600 font-bold text-sm mb-2">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </div>
                                <div class="flex items-center justify-between text-xs text-slate-500 mt-auto">
                                    <span>Stok: {{ $item->stock }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] border border-slate-200">
                                        {{ strtoupper(str_replace('_', ' ', $item->availability)) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-sm text-slate-500">
                            Tidak ada produk yang cocok dengan filter.
                        </div>
                    @endforelse
                </div>

                <div>
                    {{ $items->links() }}
                </div>
            </div>
        </section>
    </div>
@endsection
