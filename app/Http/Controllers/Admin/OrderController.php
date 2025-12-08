<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $profile = Profile::first();

        $query = Order::with('user')
            ->orderBy('order_date', 'desc');

        if ($request->filled('q')) {
            $q = $request->q;

            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('customer_name', 'like', "%{$q}%")
                    ->orWhere('customer_phone', 'like', "%{$q}%")
                    ->orWhere('id', $q) // kalau q angka, cocokkan ID
                    ->orWhere('payment_method', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%")
                    ->orWhere('payment_status', 'like', "%{$q}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', [
            'profile' => $profile,
            'orders'  => $orders,
            'search'  => $request->q,
        ]);
    }

    public function show(Order $order)
    {
        $profile = Profile::first();
        $order->load('details.item', 'user');

        return view('admin.orders.show', compact('profile', 'order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,completed,cancelled',
            'payment_status' => 'required|in:unpaid,paid,verified',
        ]);

        $order->status = $request->status;
        $order->payment_status = $request->payment_status;

        if ($request->payment_status === 'verified') {
            $order->payment_confirmed_at = now();
            $order->payment_confirmed_by = Auth::id();
        }

        $order->save();

        return back()->with('success', 'Pesanan diperbarui.');
    }
}
