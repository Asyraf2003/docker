<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StoreTagRequest extends FormRequest {
    public function authorize(): bool { return true; }
    protected function prepareForValidation(): void {
        $this->merge(['slug' => $this->input('slug') ? Str::slug($this->input('slug')) : Str::slug($this->input('name'))]);
    }
    public function rules(): array {
        return [
            'name' => ['required','string','max:100'],
            'slug' => ['required','string','max:120','unique:tags,slug'],
        ];
    }
}

class UpdateTagRequest extends FormRequest {
    public function authorize(): bool { return true; }
    protected function prepareForValidation(): void {
        if ($this->has('slug')) $this->merge(['slug' => Str::slug($this->input('slug'))]);
    }
    public function rules(): array {
        $id = $this->route('tag')?->id;
        return [
            'name' => ['required','string','max:100'],
            'slug' => ['required','string','max:120', Rule::unique('tags','slug')->ignore($id)],
        ];
    }
}
