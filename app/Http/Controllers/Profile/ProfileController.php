<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\profile\UpdateProfilePasswordRequest;
use App\Http\Requests\profile\UpdateProfileRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function profile(){
        return response()->json([
            'profile' => auth()->user()
        ], Response::HTTP_OK);
    }

    public function updateProfile(UpdateProfileRequest $request){
        $user = User::findOrFail(auth()->id());
        $user->update($request->all());

        return response()->json([   
            'message' => 'Profile info has been updated successfully.',
            'user' => $user
        ], Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdateProfilePasswordRequest $request){
        $user = User::findOrFail(auth()->id());
        $user->update([
            'password' => $request->password
        ]);

        return response()->json([
            'message' => 'Password has been updated successfully',
        ], Response::HTTP_ACCEPTED);
    }
}
