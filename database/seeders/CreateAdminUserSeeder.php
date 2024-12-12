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

            'name' => 'sorabh', 
            'gender' => 'male',
            'city' => 'Jaipur',
            'state' => 'Rajasthan',
            'email' => 'admin@gmail.com',
            'phoneno' => '9982541337',
            'country'=> 'India',
            'password' => bcrypt('123456')

        ]);

        

        $role = Role::create(['name' => 'Admin']);

         

        $permissions = Permission::pluck('id','id')->all();

       

        $role->syncPermissions($permissions);

         

        $user->assignRole([$role->id]);

    }

}