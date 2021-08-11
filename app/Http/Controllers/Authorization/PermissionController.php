<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    public function index(){
        return response()->json([
            'permissions' => Permission::all()
        ], Response::HTTP_OK);
    }
}
