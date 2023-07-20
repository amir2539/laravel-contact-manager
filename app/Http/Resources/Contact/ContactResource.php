<?php

namespace App\Http\Resources\Contact;

use App\Http\Resources\Contant\ContactNotesResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Contact
 */
class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'address' => $this->address,
            'company' => $this->whenLoaded('company', function () {
                return [
                    'id' => $this->company?->id,
                    'name' => $this->company?->name
                ];
            }),
            'notes' => $this->whenLoaded('notes', fn()=> ContactNotesResource::collection($this->notes)),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString()
        ];
    }
}
