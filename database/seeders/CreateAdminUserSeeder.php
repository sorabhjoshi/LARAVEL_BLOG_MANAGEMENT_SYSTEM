<?php

  

namespace Database\Seeders;

  

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

use App\Models\User;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

  

class CreateAdminUserSeeder extends Seeder

{

    /**

     * Run the database seeds.

     */

    public function run(): void

    {

        $user = User::create([
            'id' => 6,
            'name' => 'sorabh', 
            'email' => 'sorabh11@gmail.com',
            'password' => bcrypt('123456')

        ]);

        

        $role = Role::create(['name' => 'Admin']);

         

        $permissions = Permission::pluck('id','id')->all();

       

        $role->syncPermissions($permissions);

         

        $user->assignRole([$role->id]);

    }

}