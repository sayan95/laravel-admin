<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();
        
        $admin = Role::where(['name' => 'admin'])->first();
        $admin->permissions()->attach($permissions);


        $editor = Role::where(['name' => 'editor'])->first();
        foreach($permissions as $permission){
            if(!in_array($permission->name, ['edit_roles'])){
                $editor->permissions()->attach($permission);
            }
        }

        $viewer = Role::where(['name' => 'viewer'])->first();
        $viewerRoles = [
            'view_users',
            'view_roles',
            'view_products',
            'view_orders',
        ];
        foreach($permissions as $permission){
            if(in_array($permission->name, $viewerRoles)){
                $viewer->permissions()->attach($permission);
            }
        }
    }
}
