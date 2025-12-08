<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $profile = Profile::first();

        $carts = Cart::with('item')
            ->where('user_id', Auth::id())
            ->get();

        $total = $carts->sum(fn($c) => $c->item->price * $c->quantity);

        return view('frontend.cart.index', compact('profile', 'carts', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::findOrFail($request->item_id);

        if (!$item->is_active || $item->stock <= 0) {
            return back()->withErrors('Produk tidak tersedia.');
        }

        $cart = Cart::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'item_id' => $item->id,
            ],
            [
                'quantity' => 0,
            ]
        );

        $cart->quantity += $request->quantity;
        $cart->save();

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, Cart $cart)
    {
        $this->authorizeCart($cart);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->quantity = $request->quantity;
        $cart->save();

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(Cart $cart)
    {
        $this->authorizeCart($cart);

        $cart->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    protected function authorizeCart(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
