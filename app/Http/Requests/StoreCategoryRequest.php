<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'name_id' => ['required','string','max:150'],
            'name_en' => ['nullable','string','max:150'],
            'name_ar' => ['nullable','string','max:150'],
            'slug'    => ['required','string','max:160','unique:categories,slug'],
            'parent_id'=> ['nullable','integer','exists:categories,id'],
            'sort_order'=> ['nullable','integer','min:0'],
            'is_active'=> ['nullable','boolean'],
        ];
    }
}

class UpdateCategoryRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = $this->route('category')?->id;
        return [
            'name_id' => ['required','string','max:150'],
            'name_en' => ['nullable','string','max:150'],
            'name_ar' => ['nullable','string','max:150'],
            'slug'    => ['required','string','max:160', Rule::unique('categories','slug')->ignore($id)],
            'parent_id'=> ['nullable','integer','exists:categories,id'],
            'sort_order'=> ['nullable','integer','min:0'],
            'is_active'=> ['nullable','boolean'],
        ];
    }
}
