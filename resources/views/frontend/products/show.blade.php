@extends('layouts.main')

@section('content')
    <div class="grid md:grid-cols-[1.1fr,1fr] gap-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-4">
            <div class="aspect-[4/3] rounded-xl bg-slate-100 overflow-hidden mb-4">
                @if ($item->path)
                    <img src="{{ asset('storage/' . $item->path) }}" alt="{{ $item->item }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                        Tidak ada gambar
                    </div>
                @endif
            </div>
            <div>
                <h1 class="text-xl font-semibold mb-1">{{ $item->item }}</h1>
                <div class="text-sm text-slate-500 mb-2">
                    Kategori: {{ $item->category->category ?? '-' }}
                </div>
                <div class="prose prose-sm max-w-none text-slate-700">
                    {!! nl2br(e($item->description)) !!}
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <div class="text-xs text-slate-500 mb-1">Harga</div>
                <div class="text-2xl font-bold text-indigo-600 mb-2">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                </div>
                <div class="text-sm text-slate-500 mb-4">
                    Stok tersedia: {{ $item->stock }}
                </div>

                @auth
                    <form action="{{ route('cart.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <div>
                            <label class="block text-xs text-slate-500 mb-1">Jumlah</label>
                            <input type="number" name="quantity" min="1" value="1"
                                class="w-24 rounded-lg border-slate-300 text-sm">
                        </div>
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                            Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <div class="text-sm text-slate-500 mb-2">
                        Silakan masuk untuk melakukan pemesanan.
                    </div>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                        Masuk
                    </a>
                @endauth
            </div>

            @if ($related->isNotEmpty())
                <div class="bg-white rounded-2xl border border-slate-200 p-4">
                    <h2 class="text-sm font-semibold mb-3">Produk Terkait</h2>
                    <div class="space-y-2 text-sm">
                        @foreach ($related as $r)
                            <a href="{{ route('products.show', $r) }}"
                                class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50">
                                <span>{{ $r->item }}</span>
                                <span class="text-indigo-600 font-semibold">
                                    Rp {{ number_format($r->price, 0, ',', '.') }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
