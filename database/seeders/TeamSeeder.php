<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            [
                'name'          => 'Équipe Voirie Nord',
                'description'   => 'Responsable des arrondissements Ouidah I et II',
                'contact_phone' => '+229 97 00 00 01',
                'contact_email' => 'voirie.nord@mairie-ouidah.bj',
            ],
            [
                'name'          => 'Équipe Voirie Sud',
                'description'   => 'Responsable des arrondissements Ouidah III et IV',
                'contact_phone' => '+229 97 00 00 02',
                'contact_email' => 'voirie.sud@mairie-ouidah.bj',
            ],
            [
                'name'          => 'Équipe Voirie Est',
                'description'   => 'Responsable des arrondissements Ouidah V et Pahou',
                'contact_phone' => '+229 97 00 00 03',
                'contact_email' => 'voirie.est@mairie-ouidah.bj',
            ],
            [
                'name'          => 'Équipe Drainage',
                'description'   => 'Responsable du curage des caniveaux et drains',
                'contact_phone' => '+229 97 00 00 04',
                'contact_email' => 'drainage@mairie-ouidah.bj',
            ],
            [
                'name'          => 'Équipe Urgence',
                'description'   => 'Intervention rapide pour les situations urgentes',
                'contact_phone' => '+229 97 00 00 05',
                'contact_email' => 'urgence@mairie-ouidah.bj',
            ],
        ];

        foreach ($teams as $data) {
            Team::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
