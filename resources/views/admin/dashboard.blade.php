@extends('layouts.main')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-xl font-semibold mb-1">Dashboard Admin</h1>
            <p class="text-sm text-slate-500">
                Ringkasan penjualan dan aktivitas toko.
            </p>
        </div>

        {{-- KARTU STATISTIK --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <div class="text-xs text-slate-500 mb-1">Total Pesanan</div>
                <div class="text-2xl font-bold">{{ $totalOrders }}</div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <div class="text-xs text-slate-500 mb-1">Pendapatan</div>
                <div class="text-2xl font-bold text-emerald-600">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <div class="text-xs text-slate-500 mb-1">Produk</div>
                <div class="text-2xl font-bold">{{ $totalItems }}</div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <div class="text-xs text-slate-500 mb-1">Customer</div>
                <div class="text-2xl font-bold">{{ $totalCustomers }}</div>
            </div>
        </div>

        {{-- MENU ADMIN: INI YANG BELUM ADA DI PUNYAMU --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            <a href="{{ route('admin.items.index') }}"
                class="bg-white rounded-2xl border border-slate-200 p-4 hover:border-indigo-300 hover:shadow-md transition">
                <div class="text-xs text-slate-500 mb-1">Manajemen</div>
                <div class="font-semibold mb-1">Produk</div>
                <p class="text-xs text-slate-500">
                    Tambah, edit, dan nonaktifkan produk.
                </p>
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="bg-white rounded-2xl border border-slate-200 p-4 hover:border-indigo-300 hover:shadow-md transition">
                <div class="text-xs text-slate-500 mb-1">Manajemen</div>
                <div class="font-semibold mb-1">Kategori</div>
                <p class="text-xs text-slate-500">
                    Kelola kategori untuk mengelompokkan produk.
                </p>
            </a>

            <a href="{{ route('admin.orders.index') }}"
                class="bg-white rounded-2xl border border-slate-200 p-4 hover:border-indigo-300 hover:shadow-md transition">
                <div class="text-xs text-slate-500 mb-1">Transaksi</div>
                <div class="font-semibold mb-1">Pesanan</div>
                <p class="text-xs text-slate-500">
                    Lihat dan konfirmasi pesanan serta pembayaran.
                </p>
            </a>

            @if (auth()->user()->level === 'admin')
                <a href="{{ route('admin.users.index') }}"
                    class="bg-white rounded-2xl border border-slate-200 p-4 hover:border-indigo-300 hover:shadow-md transition">
                    <div class="text-xs text-slate-500 mb-1">Pengguna</div>
                    <div class="font-semibold mb-1">User</div>
                    <p class="text-xs text-slate-500">
                        Atur level dan status akun pengguna.
                    </p>
                </a>
            @endif



            <a href="{{ route('admin.profile.edit') }}"
                class="bg-white rounded-2xl border border-slate-200 p-4 hover:border-indigo-300 hover:shadow-md transition">
                <div class="text-xs text-slate-500 mb-1">Toko</div>
                <div class="font-semibold mb-1">Profil Toko</div>
                <p class="text-xs text-slate-500">
                    Ubah nama toko, logo, alamat, kontak, dan sosial media.
                </p>
            </a>
        </div>

        {{-- Pesanan terbaru (boleh tetap ada) --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold">Pesanan Terbaru</h2>
            </div>
            <div class="overflow-x-auto text-sm">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b text-xs text-slate-500">
                            <th class="py-2 text-left">Tanggal</th>
                            <th class="py-2 text-left">Customer</th>
                            <th class="py-2 text-left">Total</th>
                            <th class="py-2 text-left">Status</th>
                            <th class="py-2 text-left">Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr class="border-b last:border-b-0">
                                <td class="py-2">{{ $order->order_date->format('d/m/Y H:i') }}</td>
                                <td class="py-2">{{ $order->customer_name }}</td>
                                <td class="py-2">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="py-2 text-xs uppercase">{{ $order->status }}</td>
                                <td class="py-2 text-xs uppercase">{{ $order->payment_status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-slate-500">
                                    Belum ada pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
