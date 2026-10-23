<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Obtener o crear un usuario con rol 'empresa' para mantener la integridad relacional
        $userEmpresa = User::firstOrCreate(
            ['email' => 'empresa.demo@superfast.com'],
            [
                'name' => 'Empresa Demo Representante',
                'password' => Hash::make('SuperFast2026!'),
                'role' => 'empresa',
                'email_verified_at' => now(),
            ]
        );

        // 2. Crear la empresa asociada únicamente si no existe para este usuario
        Empresa::firstOrCreate(
            ['user_id' => $userEmpresa->id],
            [
                'nombre' => 'Empresa Demo',
                'direccion' => 'Bogotá',
            ]
        );
    }
}