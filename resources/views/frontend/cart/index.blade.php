@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Keranjang Belanja</h1>

    @if ($carts->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-6 text-sm text-slate-500">
            Keranjang masih kosong.
        </div>
    @else
        <div class="grid md:grid-cols-[2fr,1fr] gap-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <div class="space-y-3">
                    @foreach ($carts as $cart)
                        <div class="flex gap-3 border-b last:border-b-0 pb-3">
                            <div class="w-20 h-20 rounded-lg bg-slate-100 overflow-hidden">
                                @if ($cart->item->path)
                                    <img src="{{ asset('storage/' . $cart->item->path) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-sm">
                                    {{ $cart->item->item }}
                                </div>
                                <div class="text-xs text-slate-500 mb-1">
                                    Rp {{ number_format($cart->item->price, 0, ',', '.') }}
                                </div>
                                <form action="{{ route('cart.update', $cart) }}" method="POST"
                                    class="flex items-center gap-3 text-xs">
                                    @csrf
                                    @method('PATCH')
                                    <label>Jumlah:
                                        <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1"
                                            class="w-16 rounded border-slate-300 text-xs ml-1">
                                    </label>
                                    <button class="text-indigo-600 hover:underline">
                                        Update
                                    </button>
                                </form>
                            </div>
                            <div class="flex flex-col items-end justify-between text-right">
                                <div class="text-sm font-semibold text-indigo-600">
                                    Rp {{ number_format($cart->item->price * $cart->quantity, 0, ',', '.') }}
                                </div>
                                <form action="{{ route('cart.destroy', $cart) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs text-red-500 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-4 h-fit">
                <h2 class="text-sm font-semibold mb-3">Ringkasan</h2>
                <div class="flex items-center justify-between text-sm mb-4">
                    <span>Total</span>
                    <span class="text-lg font-bold text-indigo-600">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
                <a href="{{ route('checkout.index') }}"
                    class="w-full inline-flex items-center justify-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                    Lanjutkan ke Checkout
                </a>
            </div>
        </div>
    @endif
@endsection
