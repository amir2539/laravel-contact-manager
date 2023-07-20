<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $name
 * @property-read string $phone_number
 * @property-read ?string $email
 * @property-read ?string $address
 * @property-read ?string $company
 */
class StoreContactRequest extends FormRequest
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
            'name'         => 'required|string|max:190',
            'phone_number' => 'required|string|max:50',
            'email'        => 'nullable|email',
            'address'      => 'nullable|string',
            'company'      => 'nullable|string|max:100',
        ];
    }
}
