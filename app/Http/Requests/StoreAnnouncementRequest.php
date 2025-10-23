<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title_id' => ['required','string','max:255'],
            'title_en' => ['nullable','string','max:255'],
            'title_ar' => ['nullable','string','max:255'],

            'desc_id'  => ['nullable','string'],
            'desc_en'  => ['nullable','string'],
            'desc_ar'  => ['nullable','string'],

            'event_date' => ['required','date'],
            'link_url'   => ['nullable','url'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable','date'],
            'sort_order'   => ['nullable','integer','min:0'],
        ];
    }
}
