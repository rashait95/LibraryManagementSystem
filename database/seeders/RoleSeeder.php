<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $normalUser= Role::create(['name' => 'user']);
    

    $admin->givePermissionTo([
        'show users',
        'create user',
        'update user',
        'delete user',
        'show user profile',
        'update user profile',
        'show books',
        'create book',
        'update book',
        'delete book',
        'show authors',
        'create author',
        'update author',
        'delete author',
    ]);


    $normalUser->givePermissionTo([
        'show user profile',
        'update user profile',
        'show books',
        'borrow book',
        'show borrowed books',
      

    ]);

}
}
