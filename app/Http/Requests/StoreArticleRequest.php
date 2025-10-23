<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    protected function prepareForValidation(): void
    {
        // slug normalize
        $slug = $this->input('slug');
        if (is_string($slug) && $slug !== '') {
            $slug = Str::slug($slug) ?: null;
        } else {
            $slug = null;
        }

        // normalize booleans
        $bool = fn($k) => filter_var($this->input($k), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        // sections normalize
        $sections = $this->input('sections', []);
        if (is_array($sections)) {
            foreach ($sections as $i => &$sec) {
                $sec = is_array($sec) ? $sec : [];
                $sec['sort_order'] = isset($sec['sort_order']) && $sec['sort_order'] !== '' ? (int)$sec['sort_order'] : $i;
                if (isset($sec['remove_image'])) {
                    $sec['remove_image'] = filter_var($sec['remove_image'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
                }
            }
            unset($sec);
        }

        // categories & tags normalize
        $categoryIds = collect($this->input('category_ids', []))->map(fn($v)=>(int)$v)->filter()->unique()->values()->all();
        $tagIds      = collect($this->input('tag_ids', []))->map(fn($v)=>(int)$v)->filter()->unique()->values()->all();
        $tagSlugs    = collect($this->input('tag_slugs', []))->map(fn($v)=>Str::slug((string)$v))->filter()->unique()->values()->all();

        // status fallback: kalau is_published = true dan status kosong → published
        $status = $this->input('status');
        if (!$status && $bool('is_published')) $status = 'published';

        $this->merge([
            'slug'           => $slug,
            'sections'       => $sections,

            'is_published'   => $bool('is_published'),
            'is_featured'    => $bool('is_featured'),
            'is_hot'         => $bool('is_hot'),

            'category_ids'   => $categoryIds,
            'tag_ids'        => $tagIds,
            'tag_slugs'      => $tagSlugs,

            'status'         => $status ?: 'draft',
        ]);
    }

    public function rules(): array
    {
        return [
            // judul 3 bahasa → kamu bilang wajib lengkap
            'title_id'       => ['bail','required','string','max:255'],
            'title_en'       => ['required','string','max:255'],
            'title_ar'       => ['required','string','max:255'],

            // slug
            'slug'           => ['nullable','alpha_dash','max:255','unique:articles,slug'],

            // hero
            'hero_image'     => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],

            // excerpt & meta (opsional)
            'excerpt_id'     => ['nullable','string','max:300'],
            'excerpt_en'     => ['nullable','string','max:300'],
            'excerpt_ar'     => ['nullable','string','max:300'],
            'meta_title_id'  => ['nullable','string','max:120'],
            'meta_title_en'  => ['nullable','string','max:120'],
            'meta_title_ar'  => ['nullable','string','max:120'],
            'meta_desc_id'   => ['nullable','string','max:180'],
            'meta_desc_en'   => ['nullable','string','max:180'],
            'meta_desc_ar'   => ['nullable','string','max:180'],

            // status & jadwal
            'is_published'   => ['nullable','boolean'],
            'status'         => ['required','in:draft,scheduled,published,archived'],
            'published_at'   => ['nullable','date'],
            'scheduled_for'  => ['nullable','date','after:now'],

            // featured/hot
            'is_featured'    => ['nullable','boolean'],
            'is_hot'         => ['nullable','boolean'],
            'hot_until'      => ['nullable','date','after:now'],
            'pinned_until'   => ['nullable','date','after:now'],

            // kategori & tag
            'category_ids'   => ['nullable','array'],
            'category_ids.*' => ['integer','exists:categories,id'],
            'tag_ids'        => ['nullable','array'],
            'tag_ids.*'      => ['integer','exists:tags,id'],
            'tag_slugs'      => ['nullable','array'],
            'tag_slugs.*'    => ['string','max:120'],

            // sections
            'sections'                      => ['nullable','array'],
            'sections.*.type'               => ['required','in:paragraph,quote,image_only,embed'],
            'sections.*.sort_order'         => ['nullable','integer','min:0'],
            'sections.*.body_id'            => ['nullable','string'],
            'sections.*.body_en'            => ['nullable','string'],
            'sections.*.body_ar'            => ['nullable','string'],
            'sections.*.image'              => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'sections.*.image_alt_id'       => ['nullable','string','max:255'],
            'sections.*.image_alt_en'       => ['nullable','string','max:255'],
            'sections.*.image_alt_ar'       => ['nullable','string','max:255'],
            'sections.*.remove_image'       => ['nullable','boolean'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            $status = $this->input('status');
            if ($status === 'scheduled' && empty($this->input('scheduled_for'))) {
                $v->errors()->add('scheduled_for', 'Untuk status scheduled, tanggal scheduled_for wajib diisi & > sekarang.');
            }
            if ($status === 'published' && empty($this->input('published_at'))) {
                $v->errors()->add('published_at', 'Untuk status published, tanggal published_at wajib diisi.');
            }

            $sections = $this->input('sections', []);
            foreach ($sections as $idx => $sec) {
                $type = $sec['type'] ?? 'paragraph';
                if ($type !== 'image_only') {
                    $hasAnyBody = !empty($sec['body_id']) || !empty($sec['body_en']) || !empty($sec['body_ar']);
                    if (!$hasAnyBody) {
                        $v->errors()->add("sections.$idx.body_id", 'Minimal isi salah satu konten (ID/EN/AR).');
                    }
                }
            }
        });
    }
}
