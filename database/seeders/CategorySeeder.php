<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Domain;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $voirie       = Domain::where('slug', 'voirie')->first();
        $electricite  = Domain::where('slug', 'electricite-sbee')->first();
        $eau          = Domain::where('slug', 'eau-soneb')->first();
        $assainissement = Domain::where('slug', 'assainissement')->first();

        $categories = [
            // Voirie
            [
                'domain_id'   => $voirie?->id,
                'name'        => 'Nid-de-poule',
                'slug'        => 'nid-de-poule',
                'description' => 'Trou ou cavité dans la chaussée pouvant endommager les véhicules',
                'icon'        => 'hole',
                'color'       => '#EF4444',
            ],
            [
                'domain_id'   => $voirie?->id,
                'name'        => 'Affaissement de chaussée',
                'slug'        => 'affaissement-de-chaussee',
                'description' => 'Zone de la route qui s\'est enfoncée ou affaissée',
                'icon'        => 'road',
                'color'       => '#F97316',
            ],
            [
                'domain_id'   => $voirie?->id,
                'name'        => 'Route dégradée',
                'slug'        => 'route-degradee',
                'description' => 'Route en mauvais état général (fissures, ornières)',
                'icon'        => 'broken-road',
                'color'       => '#6B7280',
            ],
            [
                'domain_id'   => $voirie?->id,
                'name'        => 'Signalisation endommagée',
                'slug'        => 'signalisation-endommagee',
                'description' => 'Panneaux de signalisation manquants, cassés ou illisibles',
                'icon'        => 'sign',
                'color'       => '#EAB308',
            ],
            [
                'domain_id'   => $voirie?->id,
                'name'        => 'Autre problème voirie',
                'slug'        => 'autre-voirie',
                'description' => 'Tout autre problème lié à la voirie non listé ci-dessus',
                'icon'        => 'other',
                'color'       => '#6B7280',
            ],

            // Électricité SBEE
            [
                'domain_id'   => $electricite?->id,
                'name'        => 'Panne d\'éclairage public',
                'slug'        => 'panne-eclairage-public',
                'description' => 'Lampadaire cassé, éteint ou absent sur la voie publique',
                'icon'        => 'light',
                'color'       => '#F59E0B',
            ],
            [
                'domain_id'   => $electricite?->id,
                'name'        => 'Poteau électrique endommagé',
                'slug'        => 'poteau-electrique-endommage',
                'description' => 'Poteau électrique cassé, penché ou dangereux',
                'icon'        => 'bolt',
                'color'       => '#EF4444',
            ],
            [
                'domain_id'   => $electricite?->id,
                'name'        => 'Câble électrique à terre',
                'slug'        => 'cable-electrique-terre',
                'description' => 'Câble électrique tombé sur la voie publique',
                'icon'        => 'bolt',
                'color'       => '#DC2626',
            ],
            [
                'domain_id'   => $electricite?->id,
                'name'        => 'Coupure de courant',
                'slug'        => 'coupure-courant',
                'description' => 'Coupure d\'électricité affectant un quartier',
                'icon'        => 'light',
                'color'       => '#6B7280',
            ],
            [
                'domain_id'   => $electricite?->id,
                'name'        => 'Autre problème électricité',
                'slug'        => 'autre-electricite',
                'description' => 'Tout autre problème électrique non listé ci-dessus',
                'icon'        => 'other',
                'color'       => '#6B7280',
            ],

            // Eau SONEB
            [
                'domain_id'   => $eau?->id,
                'name'        => 'Fuite d\'eau',
                'slug'        => 'fuite-eau',
                'description' => 'Fuite sur une conduite d\'eau dans la voie publique',
                'icon'        => 'water',
                'color'       => '#3B82F6',
            ],
            [
                'domain_id'   => $eau?->id,
                'name'        => 'Coupure d\'eau',
                'slug'        => 'coupure-eau',
                'description' => 'Absence d\'eau dans le réseau affectant un quartier',
                'icon'        => 'water',
                'color'       => '#6B7280',
            ],
            [
                'domain_id'   => $eau?->id,
                'name'        => 'Compteur défaillant',
                'slug'        => 'compteur-defaillant',
                'description' => 'Compteur d\'eau endommagé ou dysfonctionnel',
                'icon'        => 'other',
                'color'       => '#8B5CF6',
            ],
            [
                'domain_id'   => $eau?->id,
                'name'        => 'Borne fontaine hors service',
                'slug'        => 'borne-fontaine-hors-service',
                'description' => 'Borne fontaine publique non fonctionnelle',
                'icon'        => 'water',
                'color'       => '#F97316',
            ],
            [
                'domain_id'   => $eau?->id,
                'name'        => 'Autre problème eau',
                'slug'        => 'autre-eau',
                'description' => 'Tout autre problème lié à l\'eau non listé ci-dessus',
                'icon'        => 'other',
                'color'       => '#6B7280',
            ],

            // Assainissement
            [
                'domain_id'   => $assainissement?->id,
                'name'        => 'Caniveau bouché',
                'slug'        => 'caniveau-bouche',
                'description' => 'Caniveau ou drain bloqué causant des inondations',
                'icon'        => 'drain',
                'color'       => '#8B5CF6',
            ],
            [
                'domain_id'   => $assainissement?->id,
                'name'        => 'Route inondée',
                'slug'        => 'route-inondee',
                'description' => 'Portion de route couverte d\'eau suite à des pluies',
                'icon'        => 'water',
                'color'       => '#3B82F6',
            ],
            [
                'domain_id'   => $assainissement?->id,
                'name'        => 'Dépôt sauvage de déchets',
                'slug'        => 'depot-sauvage-dechets',
                'description' => 'Accumulation de déchets sur la voie publique',
                'icon'        => 'trash',
                'color'       => '#6B7280',
            ],
            [
                'domain_id'   => $assainissement?->id,
                'name'        => 'Autre problème assainissement',
                'slug'        => 'autre-assainissement',
                'description' => 'Tout autre problème d\'assainissement non listé ci-dessus',
                'icon'        => 'other',
                'color'       => '#6B7280',
            ],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(['slug' => $data['slug']], $data);
        }

        // Associer les anciennes catégories sans domaine à "Voirie"
        if ($voirie) {
            Category::whereNull('domain_id')->update(['domain_id' => $voirie->id]);
        }
    }
}
