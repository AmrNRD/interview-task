<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permissions=[];
        $data = [
		//<editor-fold desc="User Relations" defaultstate="collapsed">
		['name' => 'read_all_users', 'guard_name' => 'staff'],
		['name' => 'read_user', 'guard_name' => 'staff'],
		['name' => 'create_user', 'guard_name' => 'staff'],
		['name' => 'edit_user', 'guard_name' => 'staff'],
		['name' => 'delete_user', 'guard_name' => 'staff'],
		//</editor-fold>

		//<editor-fold desc="Store Relations" defaultstate="collapsed">
		['name' => 'read_all_stores', 'guard_name' => 'staff'],
		['name' => 'read_store', 'guard_name' => 'staff'],
		['name' => 'create_store', 'guard_name' => 'staff'],
		['name' => 'edit_store', 'guard_name' => 'staff'],
		['name' => 'delete_store', 'guard_name' => 'staff'],
		//</editor-fold>

		];
		\Spatie\Permission\Models\Permission::create($data);

        foreach ($data as $object_data){
            array_push($permissions,\Spatie\Permission\Models\Permission::create($object_data));
        }

        $role=\Spatie\Permission\Models\Role::create(['name' => 'super_admin', 'guard_name' => 'web']);

        foreach ($permissions as $permission){
            DB::table('role_has_permissions')->updateOrInsert([
                'permission_id'=>$permission->id,
                'role_id'=>$role->id
            ],[]);
        }
    }
}
