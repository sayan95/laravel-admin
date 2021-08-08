<?php

namespace App\Http\Controllers\Authorization;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index(){
        return response()->json([
            'roles' => Role::all()
        ], Response::HTTP_OK);
    }

    public function show($id){
        $role = Role::findOrFail($id);
        
        return response()->json([
            'role' => $role
        ], response::HTTP_OK);
    }

    public function store(Request $request){
        $request ->validate([
            'name' => ['required', 'unique:roles,name']
        ]);

        $role = Role::create($request->all());

        return response()->json([
            'message' => 'Role '.$role->name.' has been creted successfully',
            'role' => $role
        ], Response::HTTP_CREATED);
    }

    public function update($id, Request $request){
        $request->validate([
            'name' => ['required', 'unique:roles,name,'.$id]
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->only('name'));

        return response()->json([
            'message' => 'Role has been updated successfully',
            'role' => $role
        ], Response::HTTP_ACCEPTED);
    }

    public function destroy($id){
        $role = Role::findOrFail($id);
        $role_name = $role->name;
        $role->delete();

        return response()->json([
            'message' => 'Role '.$role_name.' has been deleted successfully'
        ], RESPONSE::HTTP_OK);
    }

}
