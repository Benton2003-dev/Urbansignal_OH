<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Nid-de-poule',
                'slug'        => 'nid-de-poule',
                'description' => 'Trou ou cavité dans la chaussée pouvant endommager les véhicules',
                'icon'        => 'hole',
                'color'       => '#EF4444',
            ],
            [
                'name'        => 'Affaissement de chaussée',
                'slug'        => 'affaissement-de-chaussee',
                'description' => 'Zone de la route qui s\'est enfoncée ou affaissée',
                'icon'        => 'road',
                'color'       => '#F97316',
            ],
            [
                'name'        => 'Route inondée',
                'slug'        => 'route-inondee',
                'description' => 'Portion de route couverte d\'eau suite à des pluies',
                'icon'        => 'water',
                'color'       => '#3B82F6',
            ],
            [
                'name'        => 'Signalisation endommagée',
                'slug'        => 'signalisation-endommagee',
                'description' => 'Panneaux de signalisation manquants, cassés ou illisibles',
                'icon'        => 'sign',
                'color'       => '#EAB308',
            ],
            [
                'name'        => 'Caniveau bouché',
                'slug'        => 'caniveau-bouche',
                'description' => 'Caniveau ou drain bloqué causant des inondations',
                'icon'        => 'drain',
                'color'       => '#8B5CF6',
            ],
            [
                'name'        => 'Route dégradée',
                'slug'        => 'route-degradee',
                'description' => 'Route en mauvais état général (fissures, ornières)',
                'icon'        => 'broken-road',
                'color'       => '#6B7280',
            ],
            [
                'name'        => 'Éclairage public défaillant',
                'slug'        => 'eclairage-public-defaillant',
                'description' => 'Lampadaire cassé ou absent sur la voie publique',
                'icon'        => 'light',
                'color'       => '#F59E0B',
            ],
            [
                'name'        => 'Autre problème',
                'slug'        => 'autre',
                'description' => 'Tout autre problème lié à la voirie non listé ci-dessus',
                'icon'        => 'other',
                'color'       => '#10B981',
            ],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
