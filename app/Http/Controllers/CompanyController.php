<?php

namespace App\Http\Controllers;

use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\Contact\ContactResource;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $companies = Company::all();
        $data = CompanyResource::collection($companies);

        return apiResponse(data: $data);
    }

    /**
     * @param  Company  $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function contacts(Company $company)
    {
        $perPage = 10;

        $contacts = $company->contacts()
            ->with('notes')
            ->where('user_id', auth()->id())
            ->paginate();

        $data = [
            'contacts' => ContactResource::collection($contacts),
            'current_page' => $contacts->currentPage(),
            'pages' => ceil($contacts->total() / $perPage),
            'per_page' => $perPage
        ];

        return apiResponse(data: $data);
    }
}
