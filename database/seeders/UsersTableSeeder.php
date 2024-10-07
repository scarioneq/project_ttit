<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@shop.ru',
            'password' => Hash::make('QWEasd123'),
            'role' => 'admin', // Устанавливаем роль администратора
        ]);

        // Создание клиента
        User::create([
            'name' => 'Client',
            'email' => 'user@shop.ru',
            'password' => Hash::make('password'),
            'role' => 'client', // Роль клиента по умолчанию
        ]);
    }
}
