@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Checkout</h1>

    <div class="grid md:grid-cols-[2fr,1fr] gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-4">
            <h2 class="text-sm font-semibold mb-3">Data Pengiriman</h2>

            <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Nama Penerima</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', $user->name) }}"
                            class="w-full rounded-lg border-slate-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">No. Telepon</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone', $user->telp) }}"
                            class="w-full rounded-lg border-slate-300 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs text-slate-500 mb-1">Alamat Lengkap</label>
                    <textarea name="customer_address" rows="3" class="w-full rounded-lg border-slate-300 text-sm">{{ old('customer_address', $user->alamat) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs text-slate-500 mb-1">Metode Pembayaran</label>
                    <div class="flex gap-3 text-sm">
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" name="payment_method" value="cod" class="rounded border-slate-300"
                                {{ old('payment_method', 'transfer') === 'cod' ? 'checked' : '' }}>
                            <span>COD (Bayar di tempat)</span>
                        </label>
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" name="payment_method" value="transfer" class="rounded border-slate-300"
                                {{ old('payment_method', 'transfer') === 'transfer' ? 'checked' : '' }}>
                            <span>Transfer Bank</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs text-slate-500 mb-1">
                        Upload Bukti Transfer (opsional, jika pilih transfer)
                    </label>
                    <input type="file" name="payment_proof" class="w-full text-sm">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG/PNG, maks 2MB.</p>
                </div>

                <button type="submit"
                    class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                    Buat Pesanan
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 h-fit">
            <h2 class="text-sm font-semibold mb-3">Ringkasan Pesanan</h2>
            <div class="space-y-2 text-sm mb-4">
                @foreach ($carts as $cart)
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div>{{ $cart->item->item }}</div>
                            <div class="text-xs text-slate-500">x {{ $cart->quantity }}</div>
                        </div>
                        <div class="text-xs text-slate-500">
                            Rp {{ number_format($cart->item->price * $cart->quantity, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="border-t pt-3 mt-3 flex items-center justify-between text-sm">
                <span class="font-semibold">Total</span>
                <span class="text-lg font-bold text-indigo-600">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>
@endsection
