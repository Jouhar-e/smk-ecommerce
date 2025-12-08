@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Pesanan</h1>

    <div class="bg-white rounded-2xl border border-slate-200 p-4 text-sm">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4 flex gap-2 justify-end">
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, ID, status..."
                class="w-full md:w-72 rounded-xl border-slate-300 text-sm px-3 py-1.5">
            <button class="px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-700">
                Cari
            </button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                {{-- tabelmu yang lama --}}

                <thead>
                    <tr class="border-b text-xs text-slate-500">
                        <th class="py-2 text-left">Tanggal</th>
                        <th class="py-2 text-left">Customer</th>
                        <th class="py-2 text-left">Total</th>
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
                                {{ $order->customer_name }}
                            </td>
                            <td class="py-2">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td class="py-2 text-xs uppercase">
                                {{ $order->status }}
                            </td>
                            <td class="py-2 text-xs uppercase">
                                {{ $order->payment_status }}
                            </td>
                            <td class="py-2 text-right text-xs">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:underline">
                                    Detail / Ubah
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
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
