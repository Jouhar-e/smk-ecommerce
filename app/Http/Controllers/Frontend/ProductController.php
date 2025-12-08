<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use App\Models\Profile;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $profile = Profile::first();
        $categories = Category::all();

        $query = Item::where('is_active', true)
            ->with('category');

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Pencarian nama produk
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where('item', 'like', "%{$search}%");
        }

        $items = $query
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString(); // biar query string (category & q) ikut di pagination

        return view('frontend.products.index', [
            'profile'            => $profile,
            'categories'         => $categories,
            'items'              => $items,
            'currentCategoryId'  => $request->category,
            'search'             => $request->q,
        ]);
    }

    public function show(Item $item)
    {
        $profile = Profile::first();

        if (!$item->is_active) {
            abort(404);
        }

        $related = Item::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('frontend.products.show', compact('profile', 'item', 'related'));
    }
}
