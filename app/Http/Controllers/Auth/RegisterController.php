<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RegisterRequest;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        $user = User::create(
            $request->only('first_name', 'last_name', 'email')
            + ['password' => bcrypt($request->password),
                'role_id' => 3
            ]
        );

        return response()->json([
            'message' => 'User has been registerd successfully',
            'user' => $user
        ], Response::HTTP_CREATED);
    }
}
