@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Detail Pesanan #{{ $order->id }}</h1>

    <div class="grid md:grid-cols-[2fr,1fr] gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-4 text-sm">
            <div class="flex justify-between mb-3">
                <div>
                    <div class="text-xs text-slate-500">Customer</div>
                    <div class="font-semibold">{{ $order->customer_name }}</div>
                    <div class="text-xs text-slate-500">{{ $order->customer_phone }}</div>
                </div>
                <div class="text-right">
                    <div class="text-xs text-slate-500">Tanggal</div>
                    <div>{{ $order->order_date->format('d/m/Y H:i') }}</div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <div class="text-xs text-slate-500 mb-1">Alamat Pengiriman</div>
                    <div class="text-xs text-slate-600">
                        {{ $order->customer_address }}
                    </div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 mb-1">Info Pesanan</div>
                    <div class="text-xs">
                        User akun: {{ $order->user->name ?? '-' }} ({{ $order->user->email ?? '-' }})
                    </div>
                    <div class="text-xs">
                        Metode: <span class="uppercase">{{ $order->payment_method }}</span>
                    </div>
                    <div class="text-xs">
                        Status: <span class="font-semibold uppercase">{{ $order->status }}</span>
                    </div>
                    <div class="text-xs">
                        Pembayaran: <span class="font-semibold uppercase">{{ $order->payment_status }}</span>
                    </div>
                    @if ($order->payment_confirmed_at)
                        <div class="text-xs">
                            Dikonfirmasi:
                            {{ $order->payment_confirmed_at->format('d/m/Y H:i') }}
                            oleh {{ $order->confirmer->name ?? '-' }}
                        </div>
                    @endif
                    @if ($order->payment_proof_path)
                        <div class="mt-2 text-xs">
                            Bukti bayar:
                            <a href="{{ asset('storage/' . $order->payment_proof_path) }}" target="_blank"
                                class="text-indigo-600 hover:underline">
                                Lihat
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="border-t pt-3 mt-3">
                <div class="text-xs text-slate-500 mb-2">Detail Produk</div>
                <div class="space-y-2">
                    @foreach ($order->details as $detail)
                        <div class="flex justify-between">
                            <div>
                                <div>{{ $detail->item->item ?? '-' }}</div>
                                <div class="text-xs text-slate-500">
                                    Rp {{ number_format($detail->item->price ?? 0, 0, ',', '.') }}
                                    x {{ $detail->quantity }}
                                </div>
                            </div>
                            <div class="text-xs text-slate-600">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-4 text-sm">
                <h2 class="text-sm font-semibold mb-3">Ringkasan Pembayaran</h2>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Total</span>
                        <span class="text-lg font-bold text-indigo-600">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </span>
                    </div>
                    @if (!is_null($order->pay))
                        <div class="flex justify-between">
                            <span>Dibayar</span>
                            <span>Rp {{ number_format($order->pay, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if (!is_null($order->change))
                        <div class="flex justify-between">
                            <span>Kembalian</span>
                            <span>Rp {{ number_format($order->change, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-4 text-sm">
                <h2 class="text-sm font-semibold mb-3">Ubah Status</h2>

                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Status Pesanan</label>
                        <select name="status" class="w-full rounded-lg border-slate-300 text-sm">
                            @foreach (['pending', 'confirmed', 'shipped', 'completed', 'cancelled'] as $s)
                                <option value="{{ $s }}" @selected(old('status', $order->status) == $s)>
                                    {{ strtoupper($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Status Pembayaran</label>
                        <select name="payment_status" class="w-full rounded-lg border-slate-300 text-sm">
                            @foreach (['unpaid', 'paid', 'verified'] as $p)
                                <option value="{{ $p }}" @selected(old('payment_status', $order->payment_status) == $p)>
                                    {{ strtoupper($p) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
