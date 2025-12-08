<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;

class DashboardController extends Controller
{
    public function index()
    {
        $profile = Profile::first();

        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('status', ['confirmed', 'shipped', 'completed'])->sum('total');
        $totalItems = Item::count();
        $totalCustomers = User::where('level', 'customer')->count();

        $recentOrders = Order::latest('order_date')->take(5)->get();

        return view('admin.dashboard', compact(
            'profile',
            'totalOrders',
            'totalRevenue',
            'totalItems',
            'totalCustomers',
            'recentOrders'
        ));
    }
}
