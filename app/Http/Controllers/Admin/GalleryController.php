<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GalleryImage;

class GalleryController extends Controller
{
    
    public function index(Request $request)
    {
        $q         = $request->string('q')->toString();
        $published = $request->get('published'); // '', '1', '0', 'scheduled'
        $sort      = $request->get('sort', 'latest');

        $images = GalleryImage::query()
            ->when($q, fn($qr) => $qr->search($q))
            ->when($published === '1', fn($qr) => $qr->publishedNow())
            ->when($published === '0', fn($qr) => $qr->draft())
            ->when($published === 'scheduled', fn($qr) => $qr->scheduled())
            ->sortByParam($sort)
            ->paginate(12)
            ->withQueryString();

        return view('admin.gallery.index', compact('images'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_id'       => 'required|string|max:255',
            'title_en'       => 'nullable|string|max:255',
            'title_ar'       => 'nullable|string|max:255',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image_path'     => 'nullable|string',
            'image_file'     => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'link_url'       => 'nullable|url',
            'sort_order'     => 'nullable|integer|min:0',
            'is_published'   => 'nullable|boolean',
            'published_at'   => 'nullable|date',
        ]);

        if ($request->hasFile('image_file')) {
            $data['image_path'] = $request->file('image_file')->store('gallery', 'public');
        }

        $data['title_en'] = $data['title_en'] ?: $data['title_id'];
        $data['title_ar'] = $data['title_ar'] ?: $data['title_id'];

        $data['sort_order']   = $data['sort_order'] ?? 0;
        $data['is_published'] = 0;      
        $data['published_at'] = now();    

        GalleryImage::create($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Galeri berhasil ditambahkan & dipublish.');
    }

    public function edit(GalleryImage $gallery)
    {
        return view('admin.gallery.edit', ['image' => $gallery]);
    }

    public function update(Request $request, GalleryImage $gallery)
    {
        $data = $request->validate([
            'title_id'       => 'required|string|max:255',
            'title_en'       => 'nullable|string|max:255',
            'title_ar'       => 'nullable|string|max:255',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image_path'     => 'nullable|string',
            'image_file'     => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'link_url'       => 'nullable|url',
            'sort_order'     => 'nullable|integer|min:0',
            'is_published'   => 'nullable|boolean',
            'published_at'   => 'nullable|date',
        ]);

        if ($request->hasFile('image_file')) {
            $data['image_path'] = $request->file('image_file')->store('gallery', 'public');
        }

        $data['title_en'] = $data['title_en'] ?: $data['title_id'];
        $data['title_ar'] = $data['title_ar'] ?: $data['title_id'];

        $data['sort_order']   = $data['sort_order'] ?? $gallery->sort_order ?? 0;
        $isPublished = $request->boolean('is_published');  
        $data['published_at'] = now();    

        $gallery->update($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Galeri berhasil diperbarui & tanggal publish diperbarui.');
    }

    public function destroy(GalleryImage $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil dihapus.');
    }
}
