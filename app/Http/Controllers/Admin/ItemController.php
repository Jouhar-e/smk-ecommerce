<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use App\Models\Profile;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $profile = Profile::first();

        $query = Item::with('category')
            ->orderBy('created_at', 'desc');

        // filter pencarian
        if ($request->filled('q')) {
            $q = $request->q;

            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('item', 'like', "%{$q}%")
                    ->orWhereHas('category', function ($cat) use ($q) {
                        $cat->where('category', 'like', "%{$q}%");
                    });
            });
        }

        $items = $query->paginate(15)->withQueryString();

        return view('admin.items.index', [
            'profile' => $profile,
            'items'   => $items,
            'search'  => $request->q,
        ]);
    }

    public function create()
    {
        $profile = Profile::first();
        $categories = Category::all();

        return view('admin.items.create', compact('profile', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'availability' => 'required|in:in_stock,low_stock,out_of_stock,preorder',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('category_id', 'item', 'description', 'price', 'stock', 'availability');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['path'] = $request->file('image')->store('products', 'public');
        }

        Item::create($data);

        return redirect()->route('admin.items.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        $profile = Profile::first();
        $categories = Category::all();

        return view('admin.items.edit', compact('profile', 'item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'availability' => 'required|in:in_stock,low_stock,out_of_stock,preorder',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('category_id', 'item', 'description', 'price', 'stock', 'availability');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['path'] = $request->file('image')->store('products', 'public');
        }

        $item->update($data);

        return redirect()->route('admin.items.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
