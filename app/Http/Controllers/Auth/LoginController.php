<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(Request $request){
        if(Auth::attempt($request->only('email', 'password'))){
            $user = Auth::user();
            
            $token = $user->createToken('admin')->accessToken;
            $access_token = cookie('access_token', $token, 60);

            return response()->json([
                'token' => $token,
            ], Response::HTTP_OK)->withCookie($access_token);
        }

        return response()->json([
            'error' => 'Invalid email or password !'
        ], Response::HTTP_UNAUTHORIZED);
    }
}
