<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ToggleLikeRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'fp' => ['nullable','string','max:64'], 
        ];
    }
}
