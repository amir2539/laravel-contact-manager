<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * @param  RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::where([
            'email' => $request->email
        ])->first();

        if (!is_null($user)) {
            return apiResponse(Response::HTTP_BAD_REQUEST, 'There is a user with this email.');
        }

        /** @var User $user */
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $data = [
            'token' => $user->createToken('token')->plainTextToken
        ];

        return apiResponse(data: $data);
    }
}
