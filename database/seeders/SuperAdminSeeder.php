<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => env('SUPERADMIN_EMAIL', 'superadmin@urbansignal.bj')],
            [
                'name'              => 'Super Administrateur',
                'role'              => 'superadmin',
                'password'          => Hash::make(env('SUPERADMIN_PASSWORD', 'change-me-immediately')),
                'phone'             => null,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Super Admin créé : ' . env('SUPERADMIN_EMAIL', 'superadmin@urbansignal.bj'));
        $this->command->warn('Pensez à définir SUPERADMIN_EMAIL et SUPERADMIN_PASSWORD dans votre .env');
    }
}