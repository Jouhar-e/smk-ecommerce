@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Riwayat Pesanan</h1>

    <div class="bg-white rounded-2xl border border-slate-200 p-4">
        <div class="overflow-x-auto text-sm">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b text-xs text-slate-500">
                        <th class="py-2 text-left">Tanggal</th>
                        <th class="py-2 text-left">Total</th>
                        <th class="py-2 text-left">Metode</th>
                        <th class="py-2 text-left">Status</th>
                        <th class="py-2 text-left">Pembayaran</th>
                        <th class="py-2 text-left"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b last:border-b-0">
                            <td class="py-2">
                                {{ $order->order_date->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-2">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td class="py-2 text-xs uppercase">
                                {{ $order->payment_method }}
                            </td>
                            <td class="py-2 text-xs uppercase">
                                {{ $order->status }}
                            </td>
                            <td class="py-2 text-xs uppercase">
                                {{ $order->payment_status }}
                            </td>
                            <td class="py-2 text-right">
                                <a href="{{ route('orders.show', $order) }}"
                                    class="text-xs text-indigo-600 hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-slate-500">
                                Belum ada pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
