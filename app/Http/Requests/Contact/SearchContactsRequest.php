<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read ?string $name
 * @property-read ?string $company
 * @property-read ?int $per_page
 */
class SearchContactsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'company' => 'nullable|string',
            'per_page' => 'nullable|int|max:50|min:1'
        ];
    }
}
