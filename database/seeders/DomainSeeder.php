<?php

namespace Database\Seeders;

use App\Models\Domain;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    public function run(): void
    {
        $domains = [
            [
                'name'        => 'Voirie',
                'slug'        => 'voirie',
                'description' => 'Routes, nids-de-poule, signalisation et infrastructures routières',
                'color'       => '#F97316',
                'icon'        => 'road',
            ],
            [
                'name'        => 'Électricité (SBEE)',
                'slug'        => 'electricite-sbee',
                'description' => 'Pannes d\'éclairage public, câbles et poteaux électriques',
                'color'       => '#EAB308',
                'icon'        => 'lightning',
            ],
            [
                'name'        => 'Eau (SONEB)',
                'slug'        => 'eau-soneb',
                'description' => 'Fuites d\'eau, coupures et problèmes de réseau hydraulique',
                'color'       => '#3B82F6',
                'icon'        => 'water',
            ],
            [
                'name'        => 'Assainissement',
                'slug'        => 'assainissement',
                'description' => 'Caniveaux, drainage, déchets et hygiène publique',
                'color'       => '#10B981',
                'icon'        => 'trash',
            ],
        ];

        foreach ($domains as $data) {
            Domain::firstOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
