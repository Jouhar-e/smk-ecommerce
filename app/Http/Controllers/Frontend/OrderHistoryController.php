<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $profile = Profile::first();

        $orders = Order::where('user_id', Auth::id())
            ->orderBy('order_date', 'desc')
            ->paginate(10);

        return view('frontend.orders.index', compact('profile', 'orders'));
    }

    public function show(Order $order)
    {
        $profile = Profile::first();

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('details.item');

        return view('frontend.orders.show', compact('profile', 'order'));
    }
}
