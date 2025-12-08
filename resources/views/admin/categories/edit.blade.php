@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Edit Kategori</h1>

    <div class="bg-white rounded-2xl border border-slate-200 p-4 max-w-md">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs text-slate-500 mb-1">Nama Kategori</label>
                <input type="text" name="category" value="{{ old('category', $category->category) }}"
                    class="w-full rounded-lg border-slate-300 text-sm">
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                    Update
                </button>
                <a href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
