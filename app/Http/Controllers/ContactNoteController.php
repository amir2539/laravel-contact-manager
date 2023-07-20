<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactNote\DestroyNoteRequest;
use App\Http\Requests\ContactNote\StoreNoteRequest;
use App\Models\Contact;
use App\Models\ContactNote;

class ContactNoteController extends Controller
{
    public function store(StoreNoteRequest $request, Contact $contact)
    {
        $contact->notes()->create([
            'note' => $request->note
        ]);

        return apiResponse();
    }

    public function destroy(DestroyNoteRequest $request, ContactNote $note)
    {
        $note->delete();

        return apiResponse();
    }
}
