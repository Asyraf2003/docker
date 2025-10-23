<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotInfo;
use Illuminate\Http\Request;

class HotInfoController extends Controller
{
    public function index()
    {
        $items = HotInfo::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.hot_infos.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_id'  => ['required','string','max:200'],
            'title_en'  => ['nullable','string','max:200'],
            'title_ar'  => ['nullable','string','max:200'],
            'url'       => ['nullable','url'],
            'starts_at' => ['nullable','date'],
            'ends_at'   => ['nullable','date','after_or_equal:starts_at'],
            'is_active' => ['nullable','boolean'],
            'sort_order'=> ['nullable','integer','min:0'],
        ]);
        HotInfo::create($data);
        return back()->with('success','Info panas ditambahkan.');
    }

    public function update(Request $request, HotInfo $hotInfo)
    {
        $data = $request->validate([
            'title_id'  => ['required','string','max:200'],
            'title_en'  => ['nullable','string','max:200'],
            'title_ar'  => ['nullable','string','max:200'],
            'url'       => ['nullable','url'],
            'starts_at' => ['nullable','date'],
            'ends_at'   => ['nullable','date','after_or_equal:starts_at'],
            'is_active' => ['nullable','boolean'],
            'sort_order'=> ['nullable','integer','min:0'],
        ]);
        $hotInfo->update($data);
        return back()->with('success','Info panas diperbarui.');
    }

    public function destroy(HotInfo $hotInfo)
    {
        $hotInfo->delete();
        return back()->with('success','Info panas dihapus.');
    }
}
