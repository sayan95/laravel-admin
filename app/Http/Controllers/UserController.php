<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(){
        return response()->json([
            'users' => User::all()
        ], Response::HTTP_OK);
    }

    public function show($id){
        return response()->json([
            'user' => User::findOrFail($id)
        ], Response::HTTP_OK);
    }

    public function store(Request $request){
        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:4'],
        ]);

        $user = User::create($request->all());

        return response()->json([
            'message' => 'User has been created successfully',
            'user' => $user
        ], Response::HTTP_CREATED);
    }

    public function update($id, Request $request){

        $request->validate([
            'email' => ['unique:users,email,'.$id]
        ]);

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
