<?php

namespace App\Http\Controllers\Authorization;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index(){
        return response()->json([
            'roles' => RoleResource::collection(Role::with('permissions')->paginate())
        ], Response::HTTP_OK);
    }

    public function show($id){
        $role = Role::findOrFail($id);
        
        return response()->json([
            'role' => new RoleResource($role)
        ], response::HTTP_OK);
    }

    public function store(Request $request){
        $request ->validate([
            'name' => ['required', 'unique:roles,name']
        ]);

        $role = Role::create($request->all());

        if($permissions = $request->permissions){
            foreach($permissions as $permission){
                $role->permissions()->attach($permission);
            }
        }    

        return response()->json([
            'message' => 'Role '.$role->name.' has been creted successfully',
            'role' => new RoleResource(Role::with('permissions')->findOrFail($role->id))
        ], Response::HTTP_CREATED);
    }

    public function update($id, Request $request){
        $request->validate([
            'name' => ['unique:roles,name,'.$id]
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->only('name'));

        if($permissions = $request->permissions)
            $role->permissions()->sync($permissions);
        else
            $role->permissions()->sync([]);
        

        return response()->json([
            'message' => 'Role has been updated successfully',
            'role' => new RoleResource(Role::with('permissions')->findOrFail($role->id))
        ], Response::HTTP_ACCEPTED);
    }

    public function destroy($id){
        $role = Role::findOrFail($id);
        $role->permissions()->detach($role->permissions);
        
        $role_name = $role->name;
        $role->delete();

        return response()->json([
            'message' => 'Role '.$role_name.' has been deleted successfully'
        ], RESPONSE::HTTP_OK);
    }

}
