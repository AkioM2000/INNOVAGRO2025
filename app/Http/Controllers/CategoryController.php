<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Afdeling;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('afdeling')->withCount('documents')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $afdelings = Afdeling::all();
        return view('categories.create', compact('afdelings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'afdeling_id' => 'required|exists:afdelings,id'
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        $category->load(['documents.user', 'afdeling']);
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $afdelings = Afdeling::all();
        return view('categories.edit', compact('category', 'afdelings'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'afdeling_id' => 'required|exists:afdelings,id'
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->documents()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki dokumen.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
