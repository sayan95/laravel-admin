<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    public function logout(Request $request){
        if(auth()->guard('api')->check() || $request->cookie('access_token')){
            auth()->guard('api')->user()->token()->revoke();
            $deleted_token = cookie()->forget('access_token');
        }
    
        return response()->json([
            'message' => 'Logged out successfully', 
        ], Response::HTTP_OK)->withoutCookie($deleted_token);
    }
}
