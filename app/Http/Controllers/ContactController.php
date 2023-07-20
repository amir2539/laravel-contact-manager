<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\SearchContactsRequest;
use App\Http\Requests\Contact\ShowContactRequest;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Http\Resources\Contact\ContactResource;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchContactsRequest $request)
    {
        $perPage = $request->get('per_page', 10);

        $contacts = $request->user()
            ->contacts()
            ->when($request->name, function (Builder $query, string $name) {
                $query->where('name', 'LIKE', "%$name%");
            })
            ->when($request->company, function (Builder $query, string $company) {
                $query->whereHas('company', function (Builder $companyQuery) use ($company) {
                    $companyQuery->where('name', 'LIKE', "%$company%");
                });
            })
            ->with('company', 'notes')
            ->paginate($perPage);

        $data = [
            'contacts' => ContactResource::collection($contacts),
            'current_page' => $contacts->currentPage(),
            'pages' => ceil($contacts->total() / $perPage),
            'per_page' => $perPage
        ];

        return apiResponse(data: $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $contactCredentials = $request->only('phone_number', 'email', 'name', 'address');

        if ($request->company) {
            $company = Company::firstOrCreate([
                'name' => $request->company,
            ]);

            $contactCredentials['company_id'] = $company->id;
        }

        $request->user()->contacts()->create($contactCredentials);

        return apiResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowContactRequest $request, Contact $contact)
    {
        $contact->load('company', 'notes');
        $data = new ContactResource($contact);

        return apiResponse(code: Response::HTTP_CREATED, data: $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contactCredentials = $request->only('phone_number', 'email', 'name', 'address');

        if ($request->company) {
            $company = Company::firstOrCreate([
                'name' => $request->company,
            ]);

            $contactCredentials['company_id'] = $company->id;
        }

        $contact->update($contactCredentials);

        return apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShowContactRequest $request, Contact $contact)
    {
        $contact->delete();

        return apiResponse();
    }
}
