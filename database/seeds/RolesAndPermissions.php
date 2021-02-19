<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        // Permission::create(['name' => 'create user']);
        // Permission::create(['name' => 'read user']);
        // Permission::create(['name' => 'update user']);
        // Permission::create(['name' => 'delete user']);

        // Permission::create(['name' => 'create role']);
        // Permission::create(['name' => 'read role']);
        // Permission::create(['name' => 'update role']);
        // Permission::create(['name' => 'delete role']);

        // Permission::create(['name' => 'create permission']);
        // Permission::create(['name' => 'read permission']);
        // Permission::create(['name' => 'update permission']);
        // Permission::create(['name' => 'delete permission']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'super-admin']);
        // $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'diseno']);
        // $role->givePermissionTo('read user');
        // $role->givePermissionTo('update user');

		// $role = Role::create(['name' => 'moderador']);
		// // $role->givePermissionTo('create user');
  // //       $role->givePermissionTo('read user');
  // //       $role->givePermissionTo('update user');
  // //       $role->givePermissionTo('delete user'); 

 		
    }
}
