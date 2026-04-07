<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@urbansignal.bj'],
            [
                'name'     => 'Administrateur UrbanSignal',
                'email'    => 'admin@urbansignal.bj',
                'phone'    => '+229 01 97 00 00 00',
                'role'     => 'admin',
                'password' => Hash::make('Admin@2024'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Agent (secrétaire exécutif)
        User::firstOrCreate(
            ['email' => 'agent@mairie-ouidah.bj'],
            [
                'name'     => 'Koffi Agbossou',
                'email'    => 'agent@mairie-ouidah.bj',
                'phone'    => '+229 96 11 22 33',
                'role'     => 'agent',
                'password' => Hash::make('Agent@2024'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Demo citizen
        User::firstOrCreate(
            ['email' => 'citoyen@example.com'],
            [
                'name'     => 'Jean Amoussou',
                'email'    => 'citoyen@example.com',
                'phone'    => '+229 95 44 55 66',
                'role'     => 'citizen',
                'arrondissement' => 'Ouidah I',
                'password' => Hash::make('Citoyen@2024'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
    }
}
