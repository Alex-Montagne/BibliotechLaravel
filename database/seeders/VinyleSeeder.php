<?php

namespace Database\Seeders;

use App\Models\Vinyle;
use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VinyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupération des catégories pour les relations (en utilisant celles existantes)
        $jazz = Categorie::where('slug', 'jazz')->first();
        $pop = Categorie::where('slug', 'pop')->first();
        $rock = Categorie::where('slug', 'rock')->first();
        $classique = Categorie::where('slug', 'classique')->first();

        $vinyles = [
            [
                'titre' => 'Kind of Blue',
                'auteur' => 'Miles Davis',
                'annee' => 1959,
                'nb_tours' => 33,
                'num_serie' => '509-9-7064-9352-5',
                'disponible' => true,
                'categorie_id' => $jazz?->id,
            ],
            [
                'titre' => 'The Very Best of Mozart',
                'auteur' => 'Various Artists',
                'annee' => 2006,
                'nb_tours' => 45,
                'num_serie' => '009-4-1234-5679-6',
                'disponible' => true,
                'categorie_id' => $classique?->id,
            ],
            [
                'titre' => 'Harvest',
                'auteur' => 'Neil Young',
                'annee' => 1989,
                'nb_tours' => 78,
                'num_serie' => '007-2-9927-5680-2',
                'disponible' => false,
                'categorie_id' => $pop?->id,
            ],
            [
                'titre' => 'Led Zeppelin II',
                'auteur' => 'Led Zeppelin',
                'annee' => 1990,
                'nb_tours' => 33,
                'num_serie' => '978-2-1234-6332-6',
                'disponible' => true,
                'categorie_id' => $rock?->id,
            ]
        ];

        foreach ($vinyles as $vinyle) {
            Vinyle::create($vinyle);
        }
    }
}
