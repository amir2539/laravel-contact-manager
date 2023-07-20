<?php

namespace App\Http\Requests\ContactNote;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $note
 */
class StoreNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var Contact $contact */
        $contact = $this->route('contact');

        return $contact->user->is($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'note' => 'required|string'
        ];
    }
}
