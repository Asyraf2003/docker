<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class StoreHotInfoRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'title_id'  => ['required','string','max:200'],
            'title_en'  => ['nullable','string','max:200'],
            'title_ar'  => ['nullable','string','max:200'],
            'url'       => ['nullable','url'],
            'starts_at' => ['nullable','date'],
            'ends_at'   => ['nullable','date','after_or_equal:starts_at'],
            'is_active' => ['nullable','boolean'],
            'sort_order'=> ['nullable','integer','min:0'],
        ];
    }
}

class UpdateHotInfoRequest extends StoreHotInfoRequest {}
