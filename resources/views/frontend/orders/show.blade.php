@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Detail Pesanan</h1>

    <div class="grid md:grid-cols-[2fr,1fr] gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-4">
            <div class="flex justify-between mb-3 text-sm">
                <div>
                    <div class="text-xs text-slate-500">ID Pesanan</div>
                    <div class="font-semibold">#{{ $order->id }}</div>
                </div>
                <div class="text-right">
                    <div class="text-xs text-slate-500">Tanggal</div>
                    <div>{{ $order->order_date->format('d/m/Y H:i') }}</div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 text-sm mb-4">
                <div>
                    <div class="text-xs text-slate-500 mb-1">Data Penerima</div>
                    <div>{{ $order->customer_name }}</div>
                    <div class="text-slate-500 text-xs">{{ $order->customer_phone }}</div>
                    <div class="text-slate-500 text-xs mt-1">
                        {{ $order->customer_address }}
                    </div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 mb-1">Info Pesanan</div>
                    <div class="text-xs">
                        Status pesanan:
                        <span class="font-semibold uppercase">{{ $order->status }}</span>
                    </div>
                    <div class="text-xs">
                        Status pembayaran:
                        <span class="font-semibold uppercase">{{ $order->payment_status }}</span>
                    </div>
                    <div class="text-xs">
                        Metode:
                        <span class="uppercase">{{ $order->payment_method }}</span>
                    </div>

                    @if ($order->payment_proof_path)
                        <div class="mt-2 text-xs">
                            Bukti pembayaran:
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
                <div class="space-y-2 text-sm">
                    @foreach ($order->details as $detail)
                        <div class="flex justify-between">
                            <div>
                                <div>{{ $detail->item->item ?? '-' }}</div>
                                <div class="text-xs text-slate-500">
                                    Rp {{ number_format($detail->item->price ?? 0, 0, ',', '.') }} x
                                    {{ $detail->quantity }}
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

        <div class="bg-white rounded-2xl border border-slate-200 p-4 h-fit">
            <h2 class="text-sm font-semibold mb-3">Ringkasan Pembayaran</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
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
            <div class="border-t mt-3 pt-3 flex justify-between text-sm">
                <span class="font-semibold">Total</span>
                <span class="text-lg font-bold text-indigo-600">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>
@endsection
