<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Profile;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $profile = Profile::first();

        $query = Category::query()->orderBy('category');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('category', 'like', "%{$q}%");
        }

        $categories = $query->get();

        return view('admin.categories.index', [
            'profile'    => $profile,
            'categories' => $categories,
            'search'     => $request->q,
        ]);
    }

    public function create()
    {
        $profile = Profile::first();
        return view('admin.categories.create', compact('profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        Category::create($request->only('category'));

        return redirect()->route('admin.categories.index')->with('success', 'Kategori ditambahkan.');
    }

    public function edit(Category $category)
    {
        $profile = Profile::first();
        return view('admin.categories.edit', compact('profile', 'category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        $category->update($request->only('category'));

        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Kategori dihapus.');
    }
}
