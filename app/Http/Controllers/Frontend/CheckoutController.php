<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Profile;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        $user = Auth::user();

        $carts = Cart::with('item')
            ->where('user_id', $user->id)
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->withErrors('Keranjang masih kosong.');
        }

        $total = $carts->sum(fn($c) => $c->item->price * $c->quantity);

        return view('frontend.checkout.index', compact('profile', 'carts', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'customer_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,transfer',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        $carts = Cart::with('item')
            ->where('user_id', $user->id)
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->withErrors('Keranjang masih kosong.');
        }

        DB::beginTransaction();

        try {
            $total = $carts->sum(fn($c) => $c->item->price * $c->quantity);

            $order = new Order();
            $order->user_id = $user->id;
            $order->order_date = now();
            $order->total = $total;
            $order->status = 'pending';
            $order->payment_status = 'unpaid';
            $order->payment_method = $request->payment_method;
            $order->customer_name = $request->customer_name;
            $order->customer_address = $request->customer_address;
            $order->customer_phone = $request->customer_phone;

            if ($request->hasFile('payment_proof')) {
                $path = $request->file('payment_proof')->store('payment_proofs', 'public');
                $order->payment_proof_path = $path;
                $order->payment_status = 'paid';
            }

            $order->save();

            foreach ($carts as $cart) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'item_id' => $cart->item_id,
                    'quantity' => $cart->quantity,
                    'subtotal' => $cart->item->price * $cart->quantity,
                ]);

                // Kurangi stok
                $cart->item->decrement('stock', $cart->quantity);
            }

            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Terjadi kesalahan saat memproses pesanan.');
        }
    }
}
