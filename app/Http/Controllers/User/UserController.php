<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\users\UserCreateRequest;
use App\Http\Requests\users\UserUpdateRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(){
        return User::paginate();
    }

    public function show($id){
        return response()->json([
            'user' => User::findOrFail($id)
        ], Response::HTTP_OK);
    }

    public function store(UserCreateRequest $request){
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt('password')
        ]);

        return response()->json([
            'message' => 'User has been created successfully',
            'user' => $user
        ], Response::HTTP_CREATED);
    }

    public function update($id, UserUpdateRequest $request){

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json([
            'message' => 'user has been updated successfully',
            'user' => $user
        ], Response::HTTP_ACCEPTED);
    }
    
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'user has been deleted successfully',
            'user' => null
        ], Response::HTTP_NO_CONTENT);
    }
}
