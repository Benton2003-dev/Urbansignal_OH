<?php

namespace Database\Seeders;

use App\Models\Arrondissement;
use Illuminate\Database\Seeder;

class ArrondissementSeeder extends Seeder
{
    public function run(): void
    {
        $arrondissements = [
            ['name' => 'Ouidah I',   'code' => 'OUI-01', 'description' => 'Centre-ville de Ouidah'],
            ['name' => 'Ouidah II',  'code' => 'OUI-02', 'description' => 'Quartier Maro'],
            ['name' => 'Ouidah III', 'code' => 'OUI-03', 'description' => 'Quartier Sogbadji'],
            ['name' => 'Ouidah IV',  'code' => 'OUI-04', 'description' => 'Quartier Avlékété'],
            ['name' => 'Ouidah V',   'code' => 'OUI-05', 'description' => 'Quartier Djègbadji'],
            ['name' => 'Pahou',      'code' => 'OUI-06', 'description' => 'Arrondissement de Pahou'],
            ['name' => 'Savi',       'code' => 'OUI-07', 'description' => 'Arrondissement de Savi'],
            ['name' => 'Kpomassè',   'code' => 'OUI-08', 'description' => 'Arrondissement de Kpomassè'],
            ['name' => 'Houakpè-Daho', 'code' => 'OUI-09', 'description' => 'Arrondissement de Houakpè-Daho'],
            ['name' => 'Ahouandji',  'code' => 'OUI-10', 'description' => 'Arrondissement de Ahouandji'],
        ];

        foreach ($arrondissements as $data) {
            Arrondissement::firstOrCreate(['code' => $data['code']], $data);
        }
    }
}
