<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $voirie        = Domain::where('slug', 'voirie')->first();
        $electricite   = Domain::where('slug', 'electricite-sbee')->first();
        $eau           = Domain::where('slug', 'eau-soneb')->first();
        $assainissement = Domain::where('slug', 'assainissement')->first();

        $teams = [
            // Voirie
            [
                'domain_id'     => $voirie?->id,
                'name'          => 'Équipe Voirie Nord',
                'description'   => 'Responsable des arrondissements Ouidah I et II',
                'contact_phone' => '+229 97 00 00 01',
                'contact_email' => 'voirie.nord@mairie-ouidah.bj',
            ],
            [
                'domain_id'     => $voirie?->id,
                'name'          => 'Équipe Voirie Sud',
                'description'   => 'Responsable des arrondissements Ouidah III et IV',
                'contact_phone' => '+229 97 00 00 02',
                'contact_email' => 'voirie.sud@mairie-ouidah.bj',
            ],
            [
                'domain_id'     => $voirie?->id,
                'name'          => 'Équipe Voirie Est',
                'description'   => 'Responsable des arrondissements Ouidah V et Pahou',
                'contact_phone' => '+229 97 00 00 03',
                'contact_email' => 'voirie.est@mairie-ouidah.bj',
            ],
            [
                'domain_id'     => $assainissement?->id,
                'name'          => 'Équipe Drainage',
                'description'   => 'Responsable du curage des caniveaux et drains',
                'contact_phone' => '+229 97 00 00 04',
                'contact_email' => 'drainage@mairie-ouidah.bj',
            ],
            [
                'domain_id'     => $voirie?->id,
                'name'          => 'Équipe Urgence Voirie',
                'description'   => 'Intervention rapide pour les situations urgentes voirie',
                'contact_phone' => '+229 97 00 00 05',
                'contact_email' => 'urgence@mairie-ouidah.bj',
            ],
            // SBEE
            [
                'domain_id'     => $electricite?->id,
                'name'          => 'Équipe SBEE Zone A',
                'description'   => 'Techniciens SBEE responsables de la zone nord de Ouidah',
                'contact_phone' => '+229 97 00 00 10',
                'contact_email' => 'sbee.zonea@sbee.bj',
            ],
            [
                'domain_id'     => $electricite?->id,
                'name'          => 'Équipe SBEE Zone B',
                'description'   => 'Techniciens SBEE responsables de la zone sud de Ouidah',
                'contact_phone' => '+229 97 00 00 11',
                'contact_email' => 'sbee.zoneb@sbee.bj',
            ],
            // SONEB
            [
                'domain_id'     => $eau?->id,
                'name'          => 'Équipe SONEB Nord',
                'description'   => 'Techniciens SONEB responsables du réseau nord',
                'contact_phone' => '+229 97 00 00 20',
                'contact_email' => 'soneb.nord@soneb.bj',
            ],
            [
                'domain_id'     => $eau?->id,
                'name'          => 'Équipe SONEB Sud',
                'description'   => 'Techniciens SONEB responsables du réseau sud',
                'contact_phone' => '+229 97 00 00 21',
                'contact_email' => 'soneb.sud@soneb.bj',
            ],
        ];

        foreach ($teams as $data) {
            Team::firstOrCreate(['name' => $data['name']], $data);
        }

        // Associer les anciennes équipes sans domaine à "Voirie"
        if ($voirie) {
            Team::whereNull('domain_id')->update(['domain_id' => $voirie->id]);
        }
    }
}
