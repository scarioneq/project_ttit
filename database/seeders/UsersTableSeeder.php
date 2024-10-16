<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@shop.ru',
            'password' => Hash::make('QWEasd123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Client',
            'email' => 'user@shop.ru',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);
    }
}
