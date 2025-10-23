<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $cats = Category::with('parent')->ordered()->paginate(20);
        return view('admin.categories.index', compact('cats'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->ordered()->get();
        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_id' => ['required','string','max:150'],
            'name_en' => ['nullable','string','max:150'],
            'name_ar' => ['nullable','string','max:150'],
            'slug'    => ['required','string','max:160','unique:categories,slug'],
            'parent_id'=> ['nullable','integer','exists:categories,id'],
            'sort_order'=> ['nullable','integer','min:0'],
            'is_active'=> ['nullable','boolean'],
        ]);
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success','Kategori dibuat.');
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')->where('id','!=',$category->id)->ordered()->get();
        return view('admin.categories.edit', compact('category','parents'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name_id' => ['required','string','max:150'],
            'name_en' => ['nullable','string','max:150'],
            'name_ar' => ['nullable','string','max:150'],
            'slug'    => ['required','string','max:160', Rule::unique('categories','slug')->ignore($category->id)],
            'parent_id'=> ['nullable','integer','exists:categories,id'],
            'sort_order'=> ['nullable','integer','min:0'],
            'is_active'=> ['nullable','boolean'],
        ]);
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success','Kategori diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success','Kategori dihapus.');
    }
}
