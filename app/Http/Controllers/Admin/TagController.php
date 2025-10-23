<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::popular()->paginate(30);
        return view('admin.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'slug' => ['nullable','string','max:120','unique:tags,slug'],
        ]);
        $data['slug'] = $data['slug'] ? Str::slug($data['slug']) : Str::slug($data['name']);
        Tag::create($data);
        return back()->with('success','Tag dibuat.');
    }

    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'slug' => ['required','string','max:120', Rule::unique('tags','slug')->ignore($tag->id)],
        ]);
        $data['slug'] = Str::slug($data['slug']);
        $tag->update($data);
        return back()->with('success','Tag diperbarui.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success','Tag dihapus.');
    }
}
