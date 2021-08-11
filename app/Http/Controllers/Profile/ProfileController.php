<?php

namespace App\Http\Controllers\Profile;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\profile\UpdateProfileRequest;
use App\Http\Requests\profile\UpdateProfilePasswordRequest;

class ProfileController extends Controller
{
    public function profile(){
        $user = User::with('role')->findOrFail(auth()->user()->id);
        
        return (new UserResource($user))->additional([
            'permissions' => $user->permissions()
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request){
        $user = User::findOrFail(auth()->id());
        $user->update($request->all());

        return response()->json([   
            'message' => 'Profile info has been updated successfully.',
            'user' => new UserResource($user)
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
