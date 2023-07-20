<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\SearchContactsRequest;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Resources\Contact\ContactResource;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchContactsRequest $request)
    {
        $perPage = $request->get('per_page', 10);

        /** @var  $contacts */
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
            ->with('company')
            ->paginte($perPage);

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

        $company = Company::firstOrCreate([
            'name' => $request->company,
        ]);

        $request->user()->contacts()->create([
            ...$contactCredentials,
            'company_id' => $company->id,
        ]);

        return apiResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
