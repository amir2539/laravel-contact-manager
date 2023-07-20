<?php

namespace App\Http\Requests\ContactNote;

use App\Models\ContactNote;
use Illuminate\Foundation\Http\FormRequest;

class DestroyNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var ContactNote $note */
        $note = $this->route('note');

        return $note->contact->user->is($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
