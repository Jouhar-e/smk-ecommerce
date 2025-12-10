@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Pesanan</h1>

    <div class="bg-white rounded-2xl border border-slate-200 p-3 sm:p-4 text-sm">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4 flex gap-2 justify-end">
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, ID, status..."
                class="w-full md:w-72 rounded-xl border-slate-300 text-sm px-3 py-1.5">
            <button class="px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-700">
                Cari
            </button>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200 p-3 sm:p-4 text-sm">
            <div class="overflow-x-auto -mx-2 sm:mx-0">
                <table class="min-w-full border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="border-b text-[11px] sm:text-xs text-slate-500">
                            <th class="py-2 px-2 text-left whitespace-nowrap">Tanggal</th>
                            <th class="py-2 px-2 text-left whitespace-nowrap">Customer</th>
                            <th class="py-2 px-2 text-left whitespace-nowrap">Total</th>
                            <th class="py-2 px-2 text-left whitespace-nowrap">Status</th>
                            <th class="py-2 px-2 text-left whitespace-nowrap">Pembayaran</th>
                            <th class="py-2 px-2 text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="border-b last:border-b-0">
                                <td class="py-2 px-2 align-top whitespace-nowrap">
                                    {{ $order->order_date->format('d/m/Y H:i') }}
                                </td>

                                <td class="py-2 px-2 align-top">
                                    <div class="font-medium">{{ $order->customer_name }}</div>
                                    <div class="text-[11px] text-slate-500 hidden sm:block">
                                        {{ Str::limit($order->customer_address, 40) }}
                                    </div>
                                </td>

                                <td class="py-2 px-2 align-top whitespace-nowrap">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </td>

                                <td class="py-2 px-2 align-top text-[11px] uppercase text-center">
                                    {{ $order->status }}
                                </td>

                                <td class="py-2 px-2 align-top text-[11px] uppercase text-center">
                                    {{ $order->payment_status }}
                                </td>

                                <td class="py-2 px-2 align-top text-right whitespace-nowrap">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="text-indigo-600 hover:underline text-xs">
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

    </div>
@endsection
