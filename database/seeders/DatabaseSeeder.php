<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Usuario cliente de prueba (idempotente para evitar duplicados)
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'cliente',
                'email_verified_at' => now(),
            ]
        );

        // Ejecutar seeder de empresa
        $this->call([
            EmpresaSeeder::class,
        ]);
    }
}