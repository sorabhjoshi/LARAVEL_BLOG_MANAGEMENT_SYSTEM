<?php

  

namespace Database\Seeders;

  

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

  

class PermissionTableSeeder extends Seeder

{

    /**

     * Run the database seeds.

     */

    public function run(): void

    {

        $permissions = [

           'role-list',

           'role-create',

           'role-edit',

           'role-delete',
           
           'blog-list',
           
           'blog-create',
           
           'blog-edit',
           
           'blog-delete',

           'news-list',
           
           'news-create',
           
           'news-edit',
           
           'news-delete',

           'newscat-list',
           
           'newscat-create',
           
           'newscat-edit',
           
           'newscat-delete',

           'blogcat-list',
           
           'blogcat-create',
           
           'blogcat-edit',
           
           'blogcat-delete',

        ];

        

        foreach ($permissions as $permission) {

             Permission::create(['name' => $permission]);

        }

    }

}