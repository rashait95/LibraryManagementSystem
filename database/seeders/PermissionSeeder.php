<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

   

    public function run(): void
    {


        $permissions = [
            'show roles',
            'create role',
            'update role',
            'delete role',
            'show users',
            'create user',
            'update user',
            'delete user',
            'show books',
            'create book',
            'update book',
            'delete book',
            'show user profile',
            'update user profile',
            'borrow book',
            'show borrowed books',
            'show authors',
            'create author',
            'update author',
            'delete author',
         ];
         
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
          }
    }
}
