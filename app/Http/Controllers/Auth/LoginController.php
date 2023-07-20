<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request)
    {
        /** @var User $user */
        $user = User::where([
            'email' => $request->email
        ])->first();

        if (is_null($user) || !Hash::check($request->password, $user->password)) {
            return apiResponse(Response::HTTP_BAD_REQUEST, 'Invalid email or password');
        }

        $data = [
            'token' => $user->createToken('token')->plainTextToken
        ];

        return apiResponse(data: $data);
    }
}
