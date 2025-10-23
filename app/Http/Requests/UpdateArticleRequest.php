<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    protected function prepareForValidation(): void
    {
        // slug: prioritas input->slug || input->title_id || current slug
        $slug = $this->input('slug') ?: $this->input('title_id') ?: ($this->route('article')?->slug);
        $slug = is_string($slug) ? (Str::slug(trim($slug)) ?: null) : null;

        $bool = fn($k) => $this->has($k) ? (filter_var($this->input($k), FILTER_VALIDATE_BOOLEAN) ? 1 : 0) : $this->route('article')?->$k;

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

        $categoryIds = collect($this->input('category_ids', []))->map(fn($v)=>(int)$v)->filter()->unique()->values()->all();
        $tagIds      = collect($this->input('tag_ids', []))->map(fn($v)=>(int)$v)->filter()->unique()->values()->all();
        $tagSlugs    = collect($this->input('tag_slugs', []))->map(fn($v)=>Str::slug((string)$v))->filter()->unique()->values()->all();

        // status fallback
        $status = $this->input('status') ?: $this->route('article')?->status;
        if (!$status && $bool('is_published')) $status = 'published';

        $this->merge([
            'slug'           => $slug,
            'sections'       => $sections,
            'category_ids'   => $categoryIds,
            'tag_ids'        => $tagIds,
            'tag_slugs'      => $tagSlugs,

            'is_published'   => $bool('is_published'),
            'is_featured'    => $bool('is_featured'),
            'is_hot'         => $bool('is_hot'),
            'status'         => $status ?: 'draft',
        ]);
    }

    public function rules(): array
    {
        $article   = $this->route('article');
        $articleId = $article?->id;

        return [
            'title_id'       => ['bail','required','string','max:255'],
            'title_en'       => ['required','string','max:255'],
            'title_ar'       => ['required','string','max:255'],

            'slug'           => ['nullable','alpha_dash','max:255', Rule::unique('articles','slug')->ignore($articleId)],

            'hero_image'     => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],

            'excerpt_id'     => ['nullable','string','max:300'],
            'excerpt_en'     => ['nullable','string','max:300'],
            'excerpt_ar'     => ['nullable','string','max:300'],
            'meta_title_id'  => ['nullable','string','max:120'],
            'meta_title_en'  => ['nullable','string','max:120'],
            'meta_title_ar'  => ['nullable','string','max:120'],
            'meta_desc_id'   => ['nullable','string','max:180'],
            'meta_desc_en'   => ['nullable','string','max:180'],
            'meta_desc_ar'   => ['nullable','string','max:180'],

            'is_published'   => ['sometimes','boolean'],
            'status'         => ['required','in:draft,scheduled,published,archived'],
            'published_at'   => ['nullable','date'],
            'scheduled_for'  => ['nullable','date','after:now'],

            'is_featured'    => ['nullable','boolean'],
            'is_hot'         => ['nullable','boolean'],
            'hot_until'      => ['nullable','date','after:now'],
            'pinned_until'   => ['nullable','date','after:now'],

            'category_ids'   => ['nullable','array'],
            'category_ids.*' => ['integer','exists:categories,id'],
            'tag_ids'        => ['nullable','array'],
            'tag_ids.*'      => ['integer','exists:tags,id'],
            'tag_slugs'      => ['nullable','array'],
            'tag_slugs.*'    => ['string','max:120'],

            // pada update, minimal 1 section
            'sections'                      => ['required','array','min:1'],
            'sections.*.id'                 => [
                'nullable','integer',
                Rule::exists('article_sections','id')->where(fn($q) => $q->where('article_id', $articleId)),
            ],
            'sections.*.type'               => ['required','in:paragraph,quote,image_only,embed'],
            'sections.*.sort_order'         => ['required','integer','min:0'],
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
