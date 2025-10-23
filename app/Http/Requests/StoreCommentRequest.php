<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'body'        => ['required','string','min:3'],
            'parent_id'   => ['nullable','integer','exists:comments,id'],
            'guest_name'  => ['nullable','string','max:100'],
            'guest_email' => ['nullable','email','max:150'],
        ];
    }
}
