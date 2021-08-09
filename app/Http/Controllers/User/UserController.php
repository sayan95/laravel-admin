<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\users\UserCreateRequest;
use App\Http\Requests\users\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(){
        return response()->json([
            'users' => UserResource::collection(User::with('role')->paginate())
        ], Response::HTTP_OK);
    }

    public function show($id){
        return response()->json([
            'user' => new UserResource(User::with('role')->findOrFail($id))
        ], Response::HTTP_OK);
    }

    public function store(UserCreateRequest $request){
        $user = User::create(
            $request->only('first_name', 'last_name', 'email', 'role_id')
            + [ 'password' => bcrypt('password')]
        );

        return response()->json([
            'message' => 'User has been created successfully',
            'user' => $user
        ], Response::HTTP_CREATED);
    }

    public function update(UserUpdateRequest $request, $id){

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
        ], Response::HTTP_OK);
    }
}
