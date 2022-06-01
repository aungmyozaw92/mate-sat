<?php

use App\Models\Department;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'name' => 'Super Admin', 
        	'username' => 'admin', 
        	'email' => 'admin@gmail.com',
        	'password' => bcrypt('123456'),
        	'department_id' => Department::first()->id,
        ]);
  
        // $role = Role::create(['name' => 'Admin']);
        $role = Role::find(1);
   
        $permissions = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);
    }
}
