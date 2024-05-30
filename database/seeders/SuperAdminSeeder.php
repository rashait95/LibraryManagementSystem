<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
         // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Rasha Baroudi', 
            'email' => 'rasha@gmail.com',
            'password' => Hash::make('rasha123'),
            'role_name'=>['Super Admin'],
            'status'=>'active'

        ]);
        $superAdmin->assignRole('Super Admin');


        
            // Creating Admin User
            $admin = User::create([
                'name' => 'admin', 
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role_name'=>['Admin'],
                'status'=>'active'
            ]);
            $admin->assignRole('Admin');
    }
}
